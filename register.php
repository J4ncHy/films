<?php
session_start();
include("sessionsSettings.php");
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="icons/icon.png">
    <title>Movies - Register</title>
    <style>
        input[type=text],
        input[type=email],
        input[type=password] {
            width: 30%;
            padding: 12px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 18px;
            margin-left: 35%;
        }

        p {
            margin-left: 35%;
        }
    </style>
</head>
<ul>
    <li style="float:right; margin-right:2%;"><a href="login.php">Login</a></li>
    <li style="float:right;"><a href="register.php">Register</a></li>
</ul>

<body>

    <?php
    $con = mysqli_connect($_SESSION["host"], $_SESSION["user"], $_SESSION["password"], $_SESSION["db"]);

    if (mysqli_connect_errno()) {
        echo mysqli_connect_errno();
    }

    echo '<form method = "post">
        <h1 style="margin-left:35%; margin-right:auto;">Register</h1>
        <p>Username</p>
        <input required type = "text" maxlength="30" name = "username"> </br>
        <p>Email</p>
        <input required type = "email" name = "email" > </br>
        <p>Password</p>
        <input required type = "password" name = "password"> </br> </br>
        <input type = "submit" style = "margin-left: 47.5%;" name = "submit" value = "Register">
    </form>';


    $options = [
        'cost' => 11,
    ];

    if (isset($_POST["submit"])) {
        $isCorrect = 0;
        $chk = 0;
        $pass = password_hash($_POST["password"], PASSWORD_BCRYPT, $options);
        $escaped_username = mysqli_real_escape_string($con, $_POST['username']);
        $escaped_email = mysqli_real_escape_string($con, $_POST['email']);

        $query = 'SELECT name,mail from user where name = "' . $escaped_username . '" OR mail = "' . $escaped_email . '"';
        $res =  mysqli_query($con, $query);

        while ($row = mysqli_fetch_assoc($res)) {
            $chk = 1;
            if ($row["mail"] == $escaped_email) {
                echo '<p style="font-size:20px;color:red;">E-MAIL already used!</p>';
            } else if ($row["name"] == $escaped_username) {
                echo '<p style="font-size:20px;color:red;">USERNAME already used!</p>';
            }
        }
        if ($chk == 0) $isCorrect = 1;
        if ($isCorrect == 1) {
            $query = 'INSERT INTO user(name,mail,password_hash,status,date_created) values ("' . $escaped_username . '","' . $escaped_email . '","' . $pass . '",1,now())';
            mysqli_query($con, $query);
            echo '<p style="color: green">Successfully registered!</p>';
        }
    }
    ?>

</body>

</html>