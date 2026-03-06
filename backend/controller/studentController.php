<?php
require_once '../connection.php';
require_once '../model/Student.php';

class StudentController
{
    private Student $student;

    public function __construct()
    {
        $this->student = new Student();
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function requireAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../../frontend/login.php");
            exit;
        }
    }

    private function redirect(string $path): void
    {
        header("Location: $path");
        exit;
    }

    private function renderErrors(array $errors): void
    {
        foreach ($errors as $err) {
            echo "<div class='error'>" . htmlspecialchars($err) . "</div>";
        }
    }

    // ── Edit (GET — show prefilled form) ──────────────────────────────────────

    public function edit(): void
    {
        $this->requireAuth();

        if (!isset($_GET['id'])) {
            die("No ID provided to edit.");
        }

        $editId = (int) $_GET['id'];

        try {
            $userData = $this->student->getById($editId);

            if (!$userData) {
                die("User not found.");
            }
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }

        // Handle skills safely
        $userSkills = [];
        if (!empty($userData['skills'])) {
            $decoded    = json_decode($userData['skills'], true);
            $userSkills = is_array($decoded) ? $decoded : explode(", ", $userData['skills']);
        }

    }

    // ── Update (POST — process form submission) ───────────────────────────────

    public function update(): void
    {
        $this->requireAuth();

        if (!isset($_POST['id'])) {
            die("No ID provided.");
        }

        $editId     = (int) $_POST['id'];
        $firstName  = trim($_POST['first_name']  ?? '');
        $lastName   = trim($_POST['last_name']   ?? '');
        $address    = trim($_POST['address']     ?? '');
        $country    = $_POST['country']           ?? '';
        $gender     = $_POST['gender']            ?? '';
        $department = $_POST['department']        ?? '';
        $skills     = json_encode($_POST['skills'] ?? []);

        // Validation
        $errors = [];
        if (strlen($firstName) < 2)                 $errors[] = "First name must be at least 2 characters.";
        if (strlen($lastName) < 2)                  $errors[] = "Last name must be at least 2 characters.";
        if (!in_array($gender, ['Male', 'Female'])) $errors[] = "Gender must be either 'Male' or 'Female'.";

        if (!empty($errors)) {
            $this->renderErrors($errors);
            exit;
        }

        try {
            $this->student->update($editId, [
                'f_name'     => $firstName,
                'l_name'     => $lastName,
                'address'    => $address,
                'country'    => $country,
                'gender'     => $gender,
                'skills'     => $skills,
                'department' => $department,
            ]);

            $this->redirect('../../frontend/view.php');

        } catch (PDOException $e) {
            die("Update failed: " . $e->getMessage());
        }
    }

    // ── Delete ────────────────────────────────────────────────────────────────

    public function delete(): void
    {
        $this->requireAuth();

        $id = $_GET['id'] ?? null;

        if (!$id || !ctype_digit((string) $id)) {
            die("Invalid ID.");
        }

        try {
            $this->student->delete((int) $id);
            $this->redirect('../../frontend/view.php?status=deleted');

        } catch (PDOException $e) {
            die("Delete failed: " . $e->getMessage());
        }
    }
    // ── Dispatcher ────────────────────────────────────────────────────────────

    public static function dispatch(): void
    {
        $action = $_POST['action'] ?? $_GET['action'] ?? '';

        $ctrl = new self();

        match ($action) {
            'edit'   => $ctrl->edit(),
            'update' => $ctrl->update(),
            'delete' => $ctrl->delete(),
            default  => die("Unknown action: " . htmlspecialchars($action)),
        };
    }
}

StudentController::dispatch();
?>