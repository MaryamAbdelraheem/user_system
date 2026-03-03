<?php

require '../backend/connection.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

 if(!isset($_GET['id'])) {
    die("No employee ID provided.");
    }
    $empId = $_GET['id'];
    try {

    $stmt = $pdo->prepare("SELECT * FROM student WHERE id = ?");
    $stmt->execute([$empId]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$employee){
        die("Employee not found in the system.");
    }

    
    $skillsArr = json_decode($employee['skills'], true);
    $displaySkills = is_array($skillsArr) ? implode(", ", $skillsArr) : "None";

    } catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Details</title>
    <style>
        body { font-family: Arial; background-color: #f4f4f4; padding: 40px; }
        .card { background: white; padding: 20px; border: 1px solid #ccc; width: 500px; margin: auto; }
        .card h2 { text-align:center; }
        .card p { margin: 5px 0; }
        .back-btn { text-align:center; margin-top:20px; }
        .back-btn a { text-decoration:none; }
        .back-btn button { padding:8px 20px; background:#4CAF50; color:white; border:none; cursor:pointer; }
        .back-btn button:hover { background:#45a049; }
    </style>
</head>
<body>
    <div class="card">
        <h2><?php echo htmlspecialchars($employee['f_name'] . " " . $employee['l_name']); ?></h2>

        <p><strong>ID:</strong> <?php echo htmlspecialchars($employee['id']); ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($employee['username']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($employee['address'] ?: 'N/A'); ?></p>
        <p><strong>Country:</strong> <?php echo htmlspecialchars($employee['country'] ?: 'Not Specified'); ?></p>
        <p><strong>Gender:</strong> <?php echo ucfirst(htmlspecialchars($employee['gender'])); ?></p>
        <p><strong>Skills:</strong> <?php echo htmlspecialchars($displaySkills); ?></p>
        <p><strong>Department:</strong> <?php echo htmlspecialchars($employee['department']); ?></p>
    </div>

    <div class="back-btn">
        <a href="view.php"><button>Back to All Employees</button></a>
    </div>
</html>