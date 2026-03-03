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
// 1. Get form data
$firstName  = $_POST['first_name'] ?? "";
$lastName   = $_POST['last_name'] ?? "";
$address    = $_POST['address'] ?? "";
$country    = $_POST['country'] ?? "";
$gender     = $_POST['gender'] ?? "";
$skills     = $_POST['skills'] ?? [];
$department = $_POST['department'] ?? "";

// 2. Determine title
$title = "";
if ($gender === "Male") {
    $title = "Mr.";
} elseif ($gender === "Female") {
    $title = "Miss";
}

?>


<h2>Thanks (<?php echo $title; ?>) <?php echo htmlspecialchars($firstName . " " . $lastName); ?></h2>

<h3>Please Review Your Information:</h3>

<p><strong>Name:</strong> <?php echo htmlspecialchars($firstName . " " . $lastName); ?></p>

<p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>

<p><strong>Your Skills:</strong></p>
<?php
if (!empty($skills)) {
    foreach ($skills as $skill) {
        echo htmlspecialchars($skill) . "<br>";
    }
} else {
    echo "No skills selected<br>";
}
?>

<p><strong>Department:</strong> <?php echo htmlspecialchars($department); ?></p>

<div style="text-align:center; margin-top:30px;">
    <a href="view.php">
        <button class="button">View All Users</button>
    </a>
</div>

</body>
</html>