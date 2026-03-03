<?php
$filePath = "database.txt";

if(!isset($_GET['id'])) {
    die("No ID provided for deletion.");
}

$deleteId = $_GET['id'];

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

    // Skip the user we want to delete
    if(isset($user['ID']) && $user['ID'] == $deleteId){
        continue; // skip adding this record
    }

    // Rebuild other records
    $newContent .= "=====================\n";
    foreach($user as $key => $value){
        $newContent .= $key . ": " . $value . "\n";
    }
    $newContent .= "\n";
}

// Write back to file
file_put_contents($filePath, $newContent);

// Redirect back to view.php
header("Location: ../frontend/view.php");
exit;
?>