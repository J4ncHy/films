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

    <title>Movies - Add Movie</title>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100 position-fixed">
    <ul class="navbar-nav mr-auto">
        <li class="navbar-item">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="navbar-item active">
            <a class="nav-link" href="addFilm.php">Add Movie</a>
        </li>
    </ul>
    <div>
    <ul class="navbar-nav mr-auto">
    <?php
    if(isset($_SESSION["username"])){
        echo '
        <li class="navbar-item">
            <a class="nav-link" href="logout.php">Logout (' . $_SESSION["username"] . ')</a>
        </li>';
    }else{
        echo '
        <li class="navbar-item">
            <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="navbar-item">
            <a class="nav-link" href="register.php">Register</a>
        </li>';
    }
    ?>

    </ul>
</div>
</nav>
<body class="bg-secondary h-100">
    <?php
    if (isset($_SESSION["username"])) {
        $db = new DB();
        if(!$db)
            die("Napaka - povezava s podatkovno bazo ".$db->getError());
    ?>
    <div class="row h-100">
    <div class="container-md my-auto">
        <form method="POST">
            <h1 class = "display-4 text-center">ADD MOVIE</h1>
            <div class="form-outline mb-4">
                <input type="text" name="naslov" id="nameForm" placeholder="Dune" class="form-control" required/>
                <label class="form-label" for="nameForm">Movie name</label>
            </div>

            <div class="form-outline mb-4">
                <input type="number" name="year" min=0 id="yearForm" placeholder="2021" class="form-control" required/>
                <label class="form-label" for="yearForm">Year</label>
            </div>

            <div class="form-outline mb-4">
                <input type="number" name="runtime" min=0 id="runtimeForm" placeholder="155" class="form-control" required/>
                <label class="form-label" for="runtimeForm">Runtime</label>
            </div>

            <div class="form-outline mb-4">
                <input type="text" name="director" min=0 id="directorForm" placeholder="Denis Villeneuve" class="form-control" required/>
                <label class="form-label" for="directorForm">Director</label>
            </div>
            <div class="form-outline mb-4">
                <input type="number" step="0.1" name="imdb" min=0 max=10 id="imdbForm" placeholder="8,1" class="form-control" required/>
                <label class="form-label" for="imdbForm">IMDB score</label>
            </div>
            <div class="form-outline mb-4">
                <input type="number" name="rt" min=0 max=100 id="rtForm" placeholder="83" class="form-control" required/>
                <label class="form-label" for="rtForm">RT score</label>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" value="true" id="watched" name="watched">
                <label class="form-check-label" for="watched">Set movie as watched</label>
            </div>

            <button type="submit" name="submit" class="btn btn-primary btn-block mb-4">Add movie</button>

        </form>
    </div>
    </div>


        <?php
        if (isset($_POST["submit"])) {
                $row = $db -> query('select distinct title from film where upper(title) = upper(?)',[$_POST["naslov"]]);
                if (!$db->ok()) {
                    echo '<p class="text-danger">Failure!</p>'.$db->getError();
                    die("Failure");
                }

                if (empty($row)) {
                    $db -> query('INSERT INTO film(title,year,runtime,director,imdb,rt) VALUES (?,?,?,?,?,?)', [$_POST["naslov"], $_POST["year"], $_POST["runtime"], $_POST["director"], $_POST["imdb"], $_POST["rt"]]);
                }
                $db -> query('INSERT INTO UserFilm values((select fid from film where title = ?),?,?)', [$_POST["naslov"], $_SESSION["uid"], isset($_POST["watched"])? true: false]);
                echo '<p class="text-success">Success!</p>';
        } 
    }else header("Location: login.php");
    ?>
</body>
</html>
