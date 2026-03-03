<?php
require 'connection.php';

// Check if form was submitted
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

// Basic validation
if (empty($firstName) || empty($lastName)) {
    die("First name and last name are required.");
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