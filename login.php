<?php
session_start();
include("sessionsSettings.php");
include("utils/db.php");
?>
<!DOCTYPE html>
<html class="h-100 overflow-hidden">

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="icons/icon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <title>Movies - Login</title>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100 position-fixed justify-content-end">
    <ul class="navbar-nav mr-auto">
        <li class="navbar-item">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="navbar-item">
            <a class="nav-link" href="addFilm.php">Add Movie</a>
        </li>
    </ul>
    <div>
    <ul class="navbar-nav mr-auto">
        <li class="navbar-item active">
            <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="navbar-item">
            <a class="nav-link" href="register.php">Register</a>
        </li>
    </ul>
</div>
</nav>

<body class="bg-secondary h-100">

    <?php
    $db = new DB();
    
    if(!$db)
        die("Napaka - povezava s podatkovno bazo ".$db->getError());
    ?>
    <div class="row h-100">
    <div class="container-md my-auto">
        <form method = "post">
            <h1 class = "display-4 text-center">LOGIN</h1>
                    
            <div class="form-outline mb-4">
                <input type="text" name="username" id="usernameForm" maxlength="30" class="form-control" required/>
                <label class="form-label" for="usernameForm">Username</label>
            </div>

            <div class="form-outline mb-4">
                <input type="password" name="password" id="passwordForm" class="form-control" /required>
                <label class="form-label" for="passwordForm">Password</label>
            </div>

            <button type="submit" name="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

            <div class="text-center">
                <p>Not a member? <a class="text-warning" href="register.php">Register</a></p>
            </div>
        </form>
    </div>
</div>
    <?php
    $options = [
        'cost' => 11,
    ];

    if (isset($_POST["submit"])) {
        $row = $db -> query('SELECT uid,name,password_hash from user where name = ?', [$_POST["username"]]);
        if(count($row)){
            $row = $row[0];
            if (password_verify($_POST["password"], $row["password_hash"])) {
                $_SESSION["username"] = $row["name"];
                $_SESSION["uid"] = $row["uid"];
                header('Location: index.php');
            } else {
                echo '<p style="color:red;margin-left:35%">Invalid username and password.<p>';
            }
        }
    }
    ?>

</body>
</html>