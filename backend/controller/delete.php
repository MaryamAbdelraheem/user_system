<?php

require '../connection.php';
require_once '../model/Student.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: ../../frontend/login.php");
    exit;
}
$id = $_GET['id'] ?? null;
if (!$id || !ctype_digit($id)) {
    die("Invalid ID.");
}

try{
    
    $student = new Student();
    $student->delete($id);

    header('Location: ../../frontend/view.php?status=deleted');
    exit;

}catch(PDOException $e)
{
    die("Update failed: " . $e->getMessage());

}

?>