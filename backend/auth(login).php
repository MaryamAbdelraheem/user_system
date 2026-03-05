<?php 
    require('connection.php');
try{
    $username = trim($_POST['username']??"");
    $password = $_POST['password']??"";

    $errors =[];

    //validation
    if(empty($username)){
        $errors[] = "Username is required";
    }
    if(empty($password)){
        $errors[] = "Password is required";
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        exit;
    }

    //check user:
    $stmt = $pdo->prepare("SELECT * FROM student WHERE username = ?");
    $stmt->execute([$username]);


    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])){
        session_regenerate_id(true);
        //Update the current session id with a newly generated one

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header("Location: ../frontend/done.php");
        exit;
    }else{
        echo "Invalid username or password";
    }
}catch(PDOException $e){
    die("Login failed: " . $e->getMessage());

}

?>