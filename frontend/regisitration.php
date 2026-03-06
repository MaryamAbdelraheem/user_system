<!DOCTYPE html>
<html>
<head>
    <title>ITI Form</title>
</head>
<body> <!----------------------------------------->
<!--http://localhost/ITI-Form/regisitration.php/-->


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

    .captcha-row {
        flex-direction: column;
        align-items: flex-start;
    }

    .captcha-code {
        font-weight: bold;
        margin-bottom: 5px;
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

<body>

<h2 style="text-align:center;">Registration Form</h2>

<form action="../backend/controller/authController.php" method="post" class="form-container" enctype="multipart/form-data" >
<input type="hidden" name="action" value="register">
<!--db.php -> -->
    <div class="form-row">
        <label>First Name</label>
        <input type="text" name="first_name" required>
    </div>

    <div class="form-row">
        <label>Last Name</label>
        <input type="text" name="last_name" required>
    </div>

    <div class="form-row">
        <label>Address</label>
        <textarea name="address"></textarea>
    </div>

    <div class="form-row">
        <label>Country</label>
        <select name="country">
            <option value="">Select Country</option>
            <option value="Egypt">Egypt</option>
            <option value="USA">USA</option>
        </select>
    </div>

    <div class="form-row">
        <label>Gender</label>
        <div class="inline">
            <input type="radio" name="gender" value="Male" required> Male
            <input type="radio" name="gender" value="Female"> Female
        </div>
    </div>

    <div class="form-row">
        <label>Skills</label>
        <div class="inline">
            <input type="checkbox" name="skills[]" value="PHP"> PHP
            <input type="checkbox" name="skills[]" value="MySQL"> MySQL
            <input type="checkbox" name="skills[]" value="J2SE"> J2SE
            <input type="checkbox" name="skills[]" value="PostgreSQL"> PostgreSQL
        </div>
    </div>

    <div class="form-row">
        <label>Username</label>
        <input type="text" name="username" required>
    </div>

    <div class="form-row">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>

    <div class="form-row">
        <input type="file" name="profile_image" accept="image/*">
    </div>

    <div class="form-row">
        <label>Department</label>
        <input type="text" name="department" value="OpenSource" readonly>
    </div>


    <div class="buttons">
        <input type="submit" value="Submit">
        <input type="reset" value="Reset">
    </div>

</form>

</body><!----------------------------------------->
</html>


