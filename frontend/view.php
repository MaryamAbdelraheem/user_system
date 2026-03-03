<?php
require '../backend/connection.php'; 

$stmt = $pdo->query("SELECT * FROM student");
$students = $stmt->fetchAll();
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
        foreach($students as $user){
            $skillsArr = json_decode($user['skills'], true);
            $displaySkills = is_array($skillsArr) ? implode(", ", $skillsArr) : $user['skills'];

            echo "<tr>";
            echo "<td>" . htmlspecialchars($user['id']) . "</td>";
            echo "<td>" . htmlspecialchars($user['f_name']) . "</td>";
            echo "<td>" . htmlspecialchars($user['l_name']) . "</td>";
            echo "<td>" . htmlspecialchars($user['address']) . "</td>";
            echo "<td>" . htmlspecialchars($user['country']) . "</td>";
            echo "<td>" . ucfirst(htmlspecialchars($user['gender'])) . "</td>";
            echo "<td>" . htmlspecialchars($displaySkills) . "</td>";
            echo "<td>" . htmlspecialchars($user['department']) . "</td>";

            // Edit Button - Points to your edit.php with the ID
            echo "<td>
                <a href='../backend/edit.php?id=" . $user['id'] . "' 
                class='edit-button'
                style='padding:5px 10px; background-color:orange; color:white; text-decoration:none; display:inline-block;'>
                Edit
                </a>
            </td>";

            // Delete Button - Points to your controller with action=delete
            echo "<td>
                <a href='../backend/delete.php?action=delete&id=" . $user['id'] . "' 
                onclick=\"return confirm('Are you sure you want to delete this user?');\" 
                style='padding:5px 10px; background-color:red; color:white; text-decoration:none; display:inline-block;'>
                Delete
                </a>
            </td>";

            // View Button
            echo "<td>
                <a href='view_emp.php?id=" . $user['id'] . "' 
                style='padding:5px 10px; background-color:blue; color:white; text-decoration:none; display:inline-block;'>
                View
                </a>
            </td>";
        }
        ?>
    </table>

</div>

</body>
</html>