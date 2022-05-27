<?php
session_start();
include("sessionsSettings.php");
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="icons/icon.png">
    <title>Movies - Login</title>
    <style>
        input[type=text],
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
    <li style="float:right; margin-right:2%;"><a href="login.php"><?php echo 'Login' ?></a></li>
    <li style="float:right;"><a href="register.php"><?php echo 'Register' ?></a></li>
</ul>

<body>

    <?php
    $con = mysqli_connect($_SESSION["host"], $_SESSION["user"], $_SESSION["password"], $_SESSION["db"]);
    
    if (mysqli_connect_errno()) {
        echo mysqli_connect_errno();
    }

    echo '<form method = "post">
        <h1 style="margin-left:35%; margin-right:auto;">Login</h1>
        <p>Username</p>
        <input required type = "text" maxlength="30" name = "username"> </br>
        <p>Password</p>
        <input required type = "password" name = "password"> </br> </br>
        <input type = "submit" style = "margin-left: 47.5%;" name = "submit" value="Login">
    </form>';


    $options = [
        'cost' => 11,
    ];
    $corr = 0;
    if (isset($_POST["submit"])) {

        $escaped_username = mysqli_real_escape_string($con, $_POST['username']);
        $query = 'SELECT uid,name,password_hash from user where name = "' . $escaped_username . '"';
        $res =  mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($res);
        if (password_verify($_POST["password"], $row["password_hash"])) {
            $_SESSION["username"] = $row["name"];
            $_SESSION["uid"] = $row["uid"];
            $corr = 1;
        } else {
            echo '<p style="color:red;margin-left:35%">Invalid password.<p>';
        }
    }

    if ($corr) {
        header('Location: index.php');
    }
    ?>

</body>

</html>