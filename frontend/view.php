<?php
$filePath = "../backend/database.txt";

if(!file_exists($filePath)){
    die("No data found.");
}

$content = file_get_contents($filePath);
$records = explode("=====================", $content);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Users Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .form-container {
            width: 1000px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border: 1px solid #ccc;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #eee;
            padding: 10px;
            border: 1px solid #ccc;
        }

        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .edit-button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .edit-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

<div class="form-container">
    <h2>Welcome, Users List</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Address</th>            
            <th>Country</th>
            <th>Gender</th>
            <th>Skills</th>
            <th>Department</th>
            <th>Edit</th> 
            <th>Delete</th>
            <th>View</th> 

        </tr>

        <?php
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

            echo "<tr>";
            echo "<td>".($user['ID'] ?? '')."</td>";
            echo "<td>".($user['First Name'] ?? '')."</td>";
            echo "<td>".($user['Last Name'] ?? '')."</td>";
            echo "<td>".($user['Address'] ?? '')."</td>";
            echo "<td>" . htmlspecialchars($user['Country'] ?? '') . "</td>";
            echo "<td>".($user['Gender'] ?? '')."</td>";
            echo "<td>".($user['Skills'] ?? '')."</td>";
            echo "<td>".($user['Department'] ?? '')."</td>";

            // Edit Button
            echo "<td><a href='../backend/edit.php?id=".($user['ID'] ?? '')."'>
                    <button class='edit-button'>Edit</button>
                  </a></td>";


            // Delete Button
            echo "<td>
            <a href='../backend/delete.php?id=".($user['ID'] ?? '')."' 
                onclick=\"return confirm('Are you sure you want to delete this user?');\" 
                style='padding:5px 10px; background-color:red; color:white; border:none; cursor:pointer; text-decoration:none; display:inline-block;'>
                Delete
            </a>
            </td>";

            //view employee Button
            echo "<td>
            <a href='view_emp.php?id=".($user['ID'] ?? '')."'>
            <button style='padding:5px 10px; background-color:blue; color:white; border:none; cursor:pointer;'>View</button>
            </a>
            </td>";
        }
        ?>
    </table>

</div>

</body>
</html>