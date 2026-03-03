<?php
$filePath = "database.txt";

// Check if form was submitted
if(!isset($_POST['id'])) {
    die("No ID provided.");
}

$editId = $_POST['id'];

// Collect form data
$firstName = $_POST['first_name'];
$lastName  = $_POST['last_name'];
$address   = $_POST['address'];
$country   = $_POST['country'];
$gender    = $_POST['gender'];
$skills    = isset($_POST['skills']) ? $_POST['skills'] : [];
$department= $_POST['department'];

// Read file and split records
$content = file_get_contents($filePath);
$records = explode("=====================", $content);

$newContent = "";

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

    // Check if this is the user to update
    if(isset($user['ID']) && $user['ID'] == $editId){
        // Replace with new data
        $user['First Name'] = $firstName;
        $user['Last Name']  = $lastName;
        $user['Address']    = $address;
        $user['Country']    = $country; 
        $user['Gender']     = $gender;
        $user['Skills']     = implode(", ", $skills);
        $user['Department'] = $department;
    }

    // Rebuild the record
    $newContent .= "=====================\n";
    foreach($user as $key => $value){
        $newContent .= $key . ": " . $value . "\n";
    }
    $newContent .= "\n"; // spacing between records
}

// Write back to file
file_put_contents($filePath, $newContent);

// Redirect back to view page
header("Location: ../frontend/view.php");
exit;
?>