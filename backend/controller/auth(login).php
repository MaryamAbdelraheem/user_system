<?php
require '../connection.php';
require '../model/Student.php';

try {
    $username = trim($_POST['username'] ?? "");
    $password = $_POST['password'] ?? "";

    $errors = [];

    // Validation
    if (empty($username)) $errors[] = "Username is required.";
    if (empty($password)) $errors[] = "Password is required.";

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        exit;
    }

    // Check user
    $student = new Student();
    $user = $student->getByColumn('username', $username);

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);

        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];

        header("Location: ../../frontend/done.php");
        exit;
    } else {
        echo "Invalid username or password.";
    }

} catch (PDOException $e) {
    die("Login failed: " . $e->getMessage());
}
?>