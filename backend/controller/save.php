<?php


require('../connection.php');
require_once '../model/Student.php';


$uploadDir = __DIR__ . "/../../uploads/";
$imageName = null;

try{
// Map form names to your DB columns
        $fName      = trim($_POST['first_name'] ?? "");
        $lName      = trim($_POST['last_name'] ?? "");
        $address    = trim($_POST['address'] ?? "");
        $country    = trim($_POST['country'] ?? "");
        $gender     = strtolower($_POST['gender'] ?? "");
        $department = $_POST['department'] ?? "opensource";
        $username   = trim($_POST['username'] ?? "");
        $password   = $_POST['password'] ?? "";
        $skillsArr  = $_POST['skills'] ?? [];

        $errors = [];
        //validation:
        if(strlen($fName) < 2){
                $errors[] = "First name must be at least 2 characters";
        }
        if(strlen($lName) < 2){
                $errors[] = "Last name must be at least 2 characters";
        }
        if(!in_array($gender, ['male','female'])){
                $errors[] = "Invalid gender value";
        }
        if(strlen($username) < 4){
                $errors[] = "Username must be at least 4 characters";
        }
        if(strlen($password) < 6){
                $errors[] = "Password must be at least 6 characters";
        }
        if(!empty($errors)){
                foreach ($errors as $error){
                        echo $error . "<br>";
                }
                exit;
        }

        if(!empty($_FILES['profile_image']['name'])){
                $fileTmp = $_FILES['profile_image']['tmp_name'];
                $fileName = $_FILES['profile_image']['name'];
                $fileSize = $_FILES['profile_image']['size'];
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($fileExt, $allowed) && $fileSize <= 2 * 1024 * 1024){
                        $newName = uniqid() . "." . $fileExt;
                        if (!is_dir($uploadDir)) 
                        {
                                mkdir($uploadDir, 0777, true);
                        }
                        if(move_uploaded_file($fileTmp, $uploadDir . $newName)){
                                $imageName = $newName;
                        }else{
                                die("Image upload failed. Check folder permissions.");
                        }
                        
                }else{
                        die("Invalid image type or image too large (max 2MB)");

                }
        }
        //passwrd -> hashed:
        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

        $skillsJson = json_encode($skillsArr);
        
        $student = new Student();
        $student->create([
                'f_name' => $fName,
                'l_name' => $lName,
                'address'=> $address,
                'country'=> $country,
                'gender' =>$gender,
                'department' =>$department,
                'username' =>$username,
                'password' =>$password,
                'skills' => $skillsJson,
                'profile_image'=>$imageName 
        ]);
        
        header('Location: ../../frontend/done.php');
        
        exit; 
}
catch(PDOException $e){
         die("insert failed: " . $e->getMessage());
}

?>