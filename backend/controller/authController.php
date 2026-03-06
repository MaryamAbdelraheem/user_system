<?php
    require_once '../connection.php';
    require_once '../model/Student.php';

    class AuthController {

        private Student $student;

        public function __construct()
        {
            $this->student = new Student();
        }

        //helper====================================================
        private function requireAuth(): void{
            if (!isset($_SESSION['user_id'])) {
                header("Location: ../../frontend/login.php");
                exit;
            }
        }
        private function redirect(string $path): void{
            header("Location: $path");
            exit;
        }

        private function renderErrors(array $errors): void{
            foreach($errors as $err){
                echo "<div class='error'>". htmlspecialchars($err)."</div>";
            }
        }

        private function handleImageUpload(string $uploadDir): string{
            try{
                $fileTmp  = $_FILES['profile_image']['tmp_name'];
                $fileName = $_FILES['profile_image']['name'];
                $fileSize = $_FILES['profile_image']['size'];
                $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($fileExt, $allowed) || $fileSize > 2 * 1024 * 1024) {
                    die("Invalid image type or image too large (max 2MB).");
                }
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $newName = uniqid() . '.' . $fileExt;
                        
                if (!move_uploaded_file($fileTmp, $uploadDir . $newName)) {
                    die("Image upload failed. Check folder permissions.");
                }
                return $newName;
            }catch(PDOException $e){
                    die('failed');

            }           
        }
        // ── Register (Create new student) ─────────────────────────────────────
        public function register(): void
        {
            $uploadDir = __DIR__ . "/../../uploads/";
            $imageName = null;

            try {
                // 1. Collect & sanitize input
                $fName      = trim($_POST['first_name']  ?? '');
                $lName      = trim($_POST['last_name']   ?? '');
                $address    = trim($_POST['address']     ?? '');
                $country    = trim($_POST['country']     ?? '');
                $gender     = strtolower($_POST['gender']    ?? '');
                $department = $_POST['department']           ?? 'opensource';
                $username   = trim($_POST['username']    ?? '');
                $password   = $_POST['password']             ?? '';
                $skillsArr  = $_POST['skills']               ?? [];

                // 2. Validate
                $errors = [];
                if (strlen($fName) < 2)     $errors[] = "First name must be at least 2 characters.";
                if (strlen($lName) < 2)     $errors[] = "Last name must be at least 2 characters.";
                if (!in_array($gender, ['male', 'female'])) $errors[] = "Invalid gender value.";
                if (strlen($username) < 4)  $errors[] = "Username must be at least 4 characters.";
                if (strlen($password) < 6)  $errors[] = "Password must be at least 6 characters.";

                if (!empty($errors)) {
                    $this->renderErrors($errors);
                    exit;
                }

                // 3. Handle profile image upload
                if (!empty($_FILES['profile_image']['name'])) {
                    $imageName = $this->handleImageUpload($uploadDir);
                }

                // 4. Hash password & encode skills
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $skillsJson     = json_encode($skillsArr);

                // 5. Persist
                $this->student->create([
                    'f_name'        => $fName,
                    'l_name'        => $lName,
                    'address'       => $address,
                    'country'       => $country,
                    'gender'        => $gender,
                    'department'    => $department,
                    'username'      => $username,
                    'password'      => $hashedPassword,
                    'skills'        => $skillsJson,
                    'profile_image' => $imageName,
                ]);

                $this->redirect('../../frontend/done.php');

            } catch (PDOException $e) {
                die("Registration failed: " . $e->getMessage());
            }
        }

        // ── Login ─────────────────────────────────────────────────────────────
        public function login(): void
        {
            try {
                $username = trim($_POST['username'] ?? '');
                $password = $_POST['password']       ?? '';

                // 1. Validate
                $errors = [];
                if (empty($username)) $errors[] = "Username is required.";
                if (empty($password)) $errors[] = "Password is required.";

                if (!empty($errors)) {
                    $this->renderErrors($errors);
                    exit;
                }

                // 2. Look up user & verify password
                $user = $this->student->getByColumn('username', $username);

                if ($user && password_verify($password, $user['password'])) {
                    session_regenerate_id(true);
                    $_SESSION['user_id']  = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    $this->redirect('../../frontend/done.php');
                }

            } catch (PDOException $e) {
                die("Login failed: " . $e->getMessage());
            }
        }

        // ── Logout ────────────────────────────────────────────────────────────
        public function logout(): void
        {
            // Clear session data
            $_SESSION = [];
            session_unset();
            session_destroy();

            // Expire the remember-me cookie if it exists
            if (isset($_COOKIE['remember_token'])) {
                setcookie(
                    'remember_token',
                    '',
                    time() - 3600,
                    '/',
                    '',
                    isset($_SERVER['HTTPS']),
                    true
                );
            }

           $this->redirect('../../frontend/login.php');
        }

        //change_password
        public function changePassword():void{
            $this->requireAuth();

            $errors =[];
            $success = '';
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $oldPassword     = $_POST['old_password']     ?? '';
                $newPassword     = $_POST['new_password']     ?? '';
                $confirmPassword = $_POST['confirm_password'] ?? '';

                // Validation
                if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
                    $errors[] = "All fields are required.";
                }
                if (strlen($newPassword) < 6) {
                    $errors[] = "New password must be at least 6 characters.";
                }
                if ($newPassword !== $confirmPassword) {
                    $errors[] = "New password and confirm password do not match.";
                }

                if (empty($errors)) {
                    try{
                    $user = $this->student->getById($_SESSION['user_id'], ['password']);

                    if (!$user || !password_verify($oldPassword, $user['password'])) {
                        $errors[] = "Old password is incorrect.";
                    } else {
                        $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
                        $this->student->update($_SESSION['user_id'], ['password' => $newHash]);
                        $success = "Password updated successfully!";
                    }}catch(PDOException $e){
                        die('failed' . $e->getMessage());
                    }
                }
            }
            
        }
        
        // ── Dispatcher ────────────────────────────────────────────────────────
        // Runs automatically when this file is requested directly by a form or link.
        public static function dispatch(): void
        {
            // Support both POST (forms) and GET (logout link)
            $action = $_POST['action'] ?? $_GET['action'] ?? '';

            $ctrl = new self();

            match ($action) {
                'register'       => $ctrl->register(),
                'login'          => $ctrl->login(),
                'logout'         => $ctrl->logout(),
                'changePassword' => $ctrl->changePassword(),
                default          => die("Unknown action: " . htmlspecialchars($action)),
            };
        }
    }

AuthController::dispatch();

?>