<?php
// 0. Get form data
$firstName  = $_POST['first_name'] ?? "";
$lastName   = $_POST['last_name'] ?? "";
$address    = $_POST['address'] ?? "";
$country    = $_POST['country'] ?? "";
$gender     = $_POST['gender'] ?? "";
$skills     = $_POST['skills'] ?? [];
$department = $_POST['department'] ?? "";

// 1. Save to database.txt
$filePath = "database.txt";

// Generate auto-increment ID
$id = 1;
if(file_exists($filePath)){
    $content = file_get_contents($filePath);
    preg_match_all('/ID:\s*(\d+)/', $content, $matches);
    $ids = $matches[1];
    $id = !empty($ids) ? max($ids) + 1 : 1;
}

// Prepare user data
$userData = [
    "ID" => $id,
    "First Name" => $firstName,
    "Last Name" => $lastName,
    "Address" => $address,
    "Country" => $country,
    "Gender" => $gender,
    "Skills" => implode(", ", $skills),
    "Department" => $department
];

// Write to file
$file = fopen($filePath, "a+");
fwrite($file, "=====================\n");
foreach($userData as $key => $value){
    fwrite($file, $key . ": " . $value . "\n");
}
fwrite($file, "=====================\n\n");
fclose($file);

// Redirect to view.php
header('Location: ../frontend/view.php');
exit;
?>