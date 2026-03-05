<?php


?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <style>
        body { font-family: Arial; background:#f4f4f4; padding:50px; }
        .form-container { width:400px; margin:auto; background:white; padding:30px; border:1px solid #ccc; }
        input { width:100%; padding:10px; margin:10px 0; }
        button { width:100%; padding:10px; background:#4CAF50; color:white; border:none; cursor:pointer; }
        .error { color:red; margin:10px 0; }
        .success { color:green; margin:10px 0; }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Forgot Password</h2>

    <?php
    foreach($errors as $err) echo "<div class='error'>$err</div>";
    if ($success) echo "<div class='success'>$success</div>";
    ?>

    <form method="post" action="">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Send Reset Link</button>
    </form>

    <div style="text-align:center; margin-top:15px;">
        <a href="../frontend/login.php">Back to Login</a>
    </div>
</div>
</body>
</html>