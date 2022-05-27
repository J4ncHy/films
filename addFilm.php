<?php
session_start();
include("sessionsSettings.php");
?>

<!DOCTYPE html>
<html>


<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="icons/icon.png">
    <title>Movies - Add Movie</title>
</head>
<ul>
    <li><a href="index.php">Home</a></li>
    <li><a class="active" href="addFilm.php">Add Movie</a></li>

    <li style="float:right; margin-right:20px;"><a href="logout.php"><?php echo 'Logout (' . $_SESSION["username"] . ')' ?></a></li>
</ul>
<body>

    <?php
    //require("functions.php");
    require("utils/db.php");
    if (isset($_SESSION["username"])) {
        $db = new DB();
        if(!$db)
            die("Napaka - povezava s podatkovno bazo ".$db->getError());
        //Add films

        echo '<form method="POST">
            <label>Movie name</label>
            <input type="text" name="naslov" placeholder="Movie name..." required> </br>

            <label>Release year</label>
            <input type="number" name="year" placeholder="2020" min=0 required> </br>

            <label>Run time</label>
            <input type="number" name="runtime" placeholder="120" min=0 required> </br>

            <label>Director</label>
            <input type="text" name="director" placeholder="Christopher Nolan" required> </br>
            
            <label>IMDB score</label>
            <input type="number" step="0.1" name="imdb" placeholder="7.5" required min=0 max=10> </br>

            <label>RT score</label>
            <input type="number" name="rt" placeholder="75" required min=0 max=100> </br>

            <label class="container">
                Watched movie? <input type="checkbox" name="watched" value="true"></br>
                <span class="checkmark"></span>
            </label>
            <input type="submit" name="submit">
            </form>';

        if (isset($_POST["naslov"])) {

                $row = $db -> query('select distinct title from film where upper(title) = upper(?)',[$_POST["naslov"]]);
                print_r($row);
                if (empty($row)) {
                    $db -> query('INSERT INTO film(title,year,runtime,director,imdb,rt) VALUES (?,?,?,?,?,?)', [$_POST["naslov"], $_POST["year"], $_POST["runtime"], $_POST["director"], $_POST["imdb"], $_POST["rt"]]);
                    $db -> query('INSERT INTO UserFilm values((select fid from film where title = ?),?,?)', [$_POST["naslov"], $_SESSION["uid"], $_POST["watched"]==true]);
                }
            if (!$db->ok()) {
                echo '<p style="color: red">Failure!</p>'.$db->getEror();
            }
            else if($_POST["submit"])
                echo '<p style="color: green">Success!</p>';
            } 
        } else {
        header("Location: login.php");
    }
    ?>
</body>
</html>
