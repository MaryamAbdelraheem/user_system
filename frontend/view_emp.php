<?php
if(!isset($_GET['id'])) {
    die("No employee ID provided.");
}

$empId = $_GET['id'];
$filePath = "../backend/database.txt";

// Read file and split records
$content = file_get_contents($filePath);
$records = explode("=====================", $content);
$employee = null;

foreach($records as $record){
    $record = trim($record);
    if(empty($record)) continue;

    $lines = explode("\n", $record);
    $user = [];
    foreach($lines as $line){
        if(strpos($line, ":") !== false){
            list($key, $value) = explode(":", $line, 2);
            $user[trim($key)] = trim($value);
        }
    }

    if(isset($user['ID']) && $user['ID'] == $empId){
        $employee = $user;
        break;
    }
}

if(!$employee){
    die("Employee not found.");
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
    <h2><?php echo htmlspecialchars($employee['First Name'] . " " . $employee['Last Name']); ?></h2>

    <p><strong>ID:</strong> <?php echo htmlspecialchars($employee['ID']); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($employee['Address']); ?></p>
    <p><strong>Country:</strong> <?php echo htmlspecialchars($employee['Country'] ?? ''); ?></p>
    <p><strong>Gender:</strong> <?php echo htmlspecialchars($employee['Gender']); ?></p>
    <p><strong>Skills:</strong> <?php echo htmlspecialchars($employee['Skills']); ?></p>
    <p><strong>Department:</strong> <?php echo htmlspecialchars($employee['Department']); ?></p>
</div>

<div class="back-btn">
    <a href="view.php"><button>Back to All Employees</button></a>
</div>

</body>
</html>