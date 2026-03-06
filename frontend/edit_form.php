<?php

require_once '../backend/connection.php';
require_once '../backend/model/Student.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .form-container {
            width: 600px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border: 1px solid #ccc;
        }

        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-row label {
            width: 150px;
            font-weight: bold;
        }

        .form-row input[type="text"],
        .form-row input[type="password"],
        .form-row select {
            width: 300px;
            padding: 5px;
        }

        .form-row textarea {
            width: 300px;
            height: 100px;
            padding: 5px;
        }

        .inline {
            display: flex;
            gap: 15px;
        }

        .buttons {
            text-align: center;
            margin-top: 20px;
        }

        .buttons input {
            padding: 8px 20px;
            margin: 0 10px;
            border: 1px solid black;
            background-color: #eee;
            cursor: pointer;
        }

        .buttons input:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Edit User</h2>

<form action="../backend/controller/studentController.php" method="post" class="form-container">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="id"     value="<?= $editId ?>">


    <div class="form-row">
        <label>Username</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($userData['username']); ?>" required>
    </div>

    <div class="form-row">
        <label>First Name</label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($userData['f_name']); ?>" required>
    </div>

    <div class="form-row">
        <label>Last Name</label>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($userData['l_name']); ?>" required>
    </div>

    <div class="form-row">
        <label>Address</label>
        <textarea name="address"><?php echo htmlspecialchars($userData['address']); ?></textarea>
    </div>

    <div class="form-row">
        <label>Country</label>
        <select name="country" required>
        <?php
        $countries = ["Egypt", "USA"];
        $currentCountry = htmlspecialchars($userData['country']) ?? "";
        echo '<option value="">Select Country</option>';
        foreach($countries as $c){
            $selected = ($c == $currentCountry) ? "selected" : "";
            echo '<option value="'.$c.'" '.$selected.'>'.$c.'</option>';
        }
        ?>
        </select>
    </div>

    <div class="form-row">
        <label>Gender</label>
        <div class="inline">
            <input type="radio" name="gender" value="Male" <?php if(htmlspecialchars($userData['gender'])=='Male') echo "checked"; ?>> Male
            <input type="radio" name="gender" value="Female" <?php if(htmlspecialchars($userData['gender'])=='Female') echo "checked"; ?>> Female
        </div>
    </div>

    <div class="form-row">
    <label>Skills</label>
     <div class="inline">
         <?php
            $skillsArr = $userSkills; 
            $allSkills = ["PHP", "MySQL", "J2SE", "PostgreSQL"];

            foreach($allSkills as $skill){
            $checked = in_array($skill, $skillsArr) ? "checked" : "";
              echo '<input type="checkbox" name="skills[]" value="'.$skill.'" '.$checked.'> '.$skill;
            }
            ?>
        </div>
    </div>

    <div class="form-row">
        <label>Department</label>
        <input type="text" name="department" value="<?php echo $userData['department']; ?>" readonly>
    </div>

    <div class="buttons">
        <input type="submit" value="Update">
        <input type="reset" value="Reset">
    </div>

</form>

</body>
</html>