<?php
$filePath = "database.txt";

if(!isset($_GET['id'])) {
    die("No ID provided to edit.");
}

$editId = $_GET['id'];

// Read file content
$content = file_get_contents($filePath);
$records = explode("=====================", $content);

// Initialize empty user array
$userData = [];

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

    if(isset($user['ID']) && $user['ID'] == $editId){
        $userData = $user;
        break;
    }
}

if(empty($userData)){
    die("User with ID $editId not found.");
}
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

<form action="update.php" method="post" class="form-container">

    <!-- Send ID as hidden field -->
    <input type="hidden" name="id" value="<?php echo $userData['ID']; ?>">

    <div class="form-row">
        <label>First Name</label>
        <input type="text" name="first_name" value="<?php echo $userData['First Name']; ?>" required>
    </div>

    <div class="form-row">
        <label>Last Name</label>
        <input type="text" name="last_name" value="<?php echo $userData['Last Name']; ?>" required>
    </div>

    <div class="form-row">
        <label>Address</label>
        <textarea name="address"><?php echo $userData['Address']; ?></textarea>
    </div>

    <div class="form-row">
        <label>Country</label>
        <select name="country" required>
        <?php
        $countries = ["Egypt", "USA"];
        $currentCountry = $userData['Country'] ?? "";
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
            <input type="radio" name="gender" value="Male" <?php if($userData['Gender']=='Male') echo "checked"; ?>> Male
            <input type="radio" name="gender" value="Female" <?php if($userData['Gender']=='Female') echo "checked"; ?>> Female
        </div>
    </div>

    <div class="form-row">
        <label>Skills</label>
        <div class="inline">
            <?php
            $skillsArr = explode(", ", $userData['Skills']);
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
        <input type="text" name="department" value="<?php echo $userData['Department']; ?>" readonly>
    </div>

    <div class="buttons">
        <input type="submit" value="Update">
        <input type="reset" value="Reset">
    </div>

</form>

</body>
</html>