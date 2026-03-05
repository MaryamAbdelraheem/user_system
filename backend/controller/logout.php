<?php 
require '../connection.php';
require_once '../model/Student.php';
    $_SESSION =[];
    session_unset();
    session_destroy();

    if(!isset($_COOKIE['remember_token'])){
        setcookie('remember_token','',time() - 3600,'/','',isset($_SERVER['HTTPS']), true);
    }

    header("Location: ../../frontend/login.php");
    exit;
?>