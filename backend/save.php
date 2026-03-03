<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('connection.php');
try{
// Map form names to your DB columns
        $fName      = $_POST['first_name'] ?? "";
        $lName      = $_POST['last_name'] ?? "";
        $address    = $_POST['address'] ?? "";
        $country    = $_POST['country'] ?? "";
        $gender     = strtolower($_POST['gender'] ?? ""); 
        $department = $_POST['department'] ?? "opensource";
        $username   = $_POST['username'] ?? "";
        $password   = $_POST['password'] ?? "";

        // Handle JSON skills (Must be json_encoded for MySQL 'json' type)
        $skillsArr  = $_POST['skills'] ?? [];
        $skillsJson = json_encode($skillsArr); 

        $sql = "INSERT INTO student (f_name, l_name, address, country, gender, department, username, password, skills)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$fName, $lName, $address, $country, $gender, $department, $username, $password, $skillsJson]);

        header('Location: ../frontend/view.php?status=saved');
        exit;
}
catch(PDOException $e){
         die("Update failed: " . $e->getMessage());
}

?>