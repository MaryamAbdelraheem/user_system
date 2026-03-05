<?php

require '../backend/connection.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

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
        .card { text-align: center; background: white; padding: 20px; border: 1px solid #ccc; width: 500px; margin: auto; }
        .card h2 { text-align:center; }
        .card p { margin: 5px 0; }
        .back-btn { text-align:center; margin-top:20px; }
        .back-btn a { text-decoration:none; }
        .back-btn button { padding:8px 20px; background:#4CAF50; color:white; border:none; cursor:pointer; }
        .back-btn button:hover { background:#45a049; }
        .profile-img { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 5px solid #a5bbab; margin-bottom: 15px;}
        .info {text-align: left; margin: 8px 0;font-size: 15px;color: #555;}
        .info strong {color: #333;}

    </style>
</head>
<body>
 <div class="card">

    <!-- Profile Image -->
    <?php if (!empty($employee['profile_image'])): ?>
        <img class="profile-img"
             src="../uploads/<?php echo htmlspecialchars($employee['profile_image']); ?>">
    <?php else: ?>
        <img class="profile-img"
             src="../uploads/default.png">
    <?php endif; ?>

    <h2><?php echo htmlspecialchars($employee['f_name'] . " " . $employee['l_name']); ?></h2>

    <div class="info"><strong>Username:</strong> <?php echo htmlspecialchars($employee['username']); ?></div>
    <div class="info"><strong>Address:</strong> <?php echo htmlspecialchars($employee['address'] ?: 'N/A'); ?></div>
    <div class="info"><strong>Country:</strong> <?php echo htmlspecialchars($employee['country'] ?: 'Not Specified'); ?></div>
    <div class="info"><strong>Gender:</strong> <?php echo ucfirst(htmlspecialchars($employee['gender'])); ?></div>
    <div class="info"><strong>Skills:</strong> <?php echo htmlspecialchars($displaySkills); ?></div>
    <div class="info"><strong>Department:</strong> <?php echo htmlspecialchars($employee['department']); ?></div>

    <div class="back-btn">
        <a href="view.php"><button class="back-btn">Back</button></a>
        <a href="../backend/change_password.php"><button class="back-btn">Change Password</button></a>
    </div>

</div>
</html>