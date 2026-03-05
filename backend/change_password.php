<?php
    require 'connection.php';

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    $errors = [];
    $success = "";
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $oldPassword     = $_POST['old_password'] ?? '';
        $newPassword     = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        //validation
        if(empty($oldPassword) || empty($newPassword) || empty($confirmPassword)){
            $errors[] = "All fields are required.";
        }
        if(strlen($newPassword) < 6){
            $errors[] = "New password must be at least 6 characters.";
        }
        if($newPassword !== $confirmPassword){
            $errors[] = "New password and confirm password do not match.";
        }
        if(empty($errors)){
            //get current pass hash
            $stmt = $pdo->prepare("SELECT password FROM student WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($oldPassword, $user['password'])) {
                $errors[] = "Old password is incorrect.";
            }else{
                //update password\
                $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE student SET password = ? WHERE id = ?");
                $stmt->execute([$newHash, $_SESSION['user_id']]);
                $success = "Password updated successfully!";
            }
        }
    }


?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <style>
        body { font-family: Arial; background-color: #f4f4f4; padding: 50px; }
        .form-container { width: 400px; margin:auto; background:white; padding:30px; border:1px solid #ccc; }
        h2 { text-align:center; margin-bottom:20px; }
        input { width:100%; padding:10px; margin:10px 0; }
        button { width:100%; padding:10px; background:#4CAF50; color:white; border:none; cursor:pointer; }
        button:hover { background:#45a049; }
        .error { color:red; margin:10px 0; }
        .success { color:green; margin:10px 0; }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Change Password</h2>

    <?php
    if (!empty($errors)) {
        foreach($errors as $err) {
            echo "<div class='error'>".$err."</div>";
        }
    }

    if ($success) {
        echo "<div class='success'>".$success."</div>";
    }
    ?>

    <form method="post" action="">
        <input type="password" name="old_password" placeholder="Old Password" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
        <button type="submit">Update Password</button>
    </form>

    <div style="text-align:center; margin-top:15px;">
        <a href="../frontend/view.php">Back to Dashboard</a>
    </div>
</div>
</body>
</html>