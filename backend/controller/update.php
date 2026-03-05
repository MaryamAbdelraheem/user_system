<?php
require '../connection.php';
require_once '../model/Student.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../frontend/login.php");
    exit;
}

if (!isset($_POST['id'])) {
    die("No ID provided.");
}

$editId    = $_POST['id'];
$firstName = $_POST['first_name'] ?? '';
$lastName  = $_POST['last_name'] ?? '';
$address   = $_POST['address'] ?? '';
$country   = $_POST['country'] ?? '';
$gender    = $_POST['gender'] ?? '';
$department = $_POST['department'] ?? '';

// Handle skills safely (store as JSON)
$skills = isset($_POST['skills']) 
    ? json_encode($_POST['skills']) 
    : json_encode([]);

// validation
if (empty($firstName) || strlen($firstName) < 2) {
    $errors[] = "First name must be at least 2 characters.";
}

if (empty($lastName) || strlen($lastName) < 2) {
    $errors[] = "Last name must be at least 2 characters.";
}
if (!in_array($gender, ['Male', 'Female'])) {
    $errors[] = "Gender must be either 'male' or 'female'.";
}

if (!empty($errors)) {
    foreach ($errors as $err) {
        echo $err . "<br>";
    }
    exit;
}


try {
    $student = new Student();
    $student->update($editId, [
        'f_name'     => $firstName,
        'l_name'     => $lastName,
        'address'    => $address,
        'country'    => $country,
        'gender'     => $gender,
        'skills'     => $skills,   
        'department' => $department
    ]);

} catch (PDOException $e) {
    die("Update failed: " . $e->getMessage());
}

// Redirect after update
header("Location: ../../frontend/view.php");
exit;
?>