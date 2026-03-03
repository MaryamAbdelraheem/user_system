<?php

require './backend/connection.php';

try{
$id = $_GET['id'] ?? null;
    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM student WHERE id = ?");
        $stmt->execute([$id]);
    }
    header('Location: ../frontend/view.php?status=deleted');
    exit;
}catch(PDOException $e)
{
    die("Update failed: " . $e->getMessage());

}

?>