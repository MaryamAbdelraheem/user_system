<?php
require 'connection.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../frontend/login.php");
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

    $stmt = $pdo->prepare("
        UPDATE student 
        SET 
            f_name = ?, 
            l_name = ?, 
            address = ?, 
            country = ?, 
            gender = ?, 
            skills = ?, 
            department = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $firstName,
        $lastName,
        $address,
        $country,
        $gender,
        $skills,
        $department,
        $editId
    ]);

} catch (PDOException $e) {
    die("Update failed: " . $e->getMessage());
}

// Redirect after update
header("Location: ../frontend/view.php");
exit;
?>