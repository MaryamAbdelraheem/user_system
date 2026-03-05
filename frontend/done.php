<!DOCTYPE html>
<html>
<head>
    <title>ITI Form - Thank You</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
        }

        .button {
            padding: 10px 20px; 
            background-color: #4CAF50; 
            color: white; 
            border: none; 
            cursor: pointer;
            font-size: 16px;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php

require_once '../backend/connection.php';
require_once '../backend/model/Student.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../frontend/login.php");
    exit;
}



try {
    $student = new Student();
    $user = $student->getByColumn('username', $_SESSION['username']);


    if (!$user) {
        die("User not found.");
    }

    // Assign values
    $firstName  = $user['f_name'];
    $lastName   = $user['l_name'];
    $address    = $user['address'];
    $country    = $user['country'];
    $gender     = $user['gender'];
    $skills     = json_decode($user['skills'], true); // decode JSON
    $department = $user['department'];
    $profileImage = $user['profile_image'] ?? 'default.png';

    // 2. Determine title
    $title = match($gender) {
        'Male'   => 'Mr.',
        'Female' => 'Miss',
        default  => ''
    };

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

?>
<img src="../uploads/<?php echo htmlspecialchars($profileImage); ?>" width="150" style="border-radius:50%;">

<h2>Welcome <?php echo htmlspecialchars($firstName . " " . $lastName); ?></h2>
<p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
<p><strong>Country:</strong> <?php echo htmlspecialchars($country); ?></p>
<p><strong>Gender:</strong> <?php echo htmlspecialchars($gender); ?></p>
<p><strong>Skills:</strong>
<?php 
if (!empty($skills)) {
    echo implode(", ", $skills);
} else {
    echo "No skills selected";
}
?>
</p>
<p><strong>Department:</strong> <?php echo htmlspecialchars($department); ?></p>


<div style="text-align:center; margin-top:30px;">
    <a href="view.php">
        <button style="
            padding: 10px 20px; 
            background-color: #4CAF50; 
            color: white; 
            border: none; 
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        " onmouseover="this.style.backgroundColor='#45a049'" onmouseout="this.style.backgroundColor='#4CAF50'">
            View All Users
        </button>
    </a>
</div>
</body>
</html>