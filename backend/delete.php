<?php

require '../backend/connection.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../frontend/login.php");
    exit;
}
$id = $_GET['id'] ?? null;
if (!$id || !ctype_digit($id)) {
    die("Invalid ID.");
}

try{
    //check user availabilty :
    $stmt = $pdo->prepare("SELECT * FROM student WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch();
    if(!$student){
        die('User not found');
    }

    //delete:
    $stmt = $pdo->prepare("DELETE FROM student WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: ../frontend/view.php?status=deleted');
    exit;

}catch(PDOException $e)
{
    die("Update failed: " . $e->getMessage());

}

?>