<?php
session_start(); 

// 1. Load credentials from environment variables (Never hardcode!)
$host = '127.0.0.1';
$db   = 'Student_System';
$user = 'root';
$pass = 'mrym1609';
$port = 3306;
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;port=$port;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw errors as exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use real prepared statements
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     // Connection successful
} catch (\PDOException $e) {
     // Log the error, don't show $e->getMessage() to the user (security risk)
     error_log($e->getMessage());
     exit("Database Connection Error.");
}

?>
