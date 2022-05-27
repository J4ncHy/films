<?php
session_start();
include("sessionsSettings.php");
include("utils/DB.php")
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="icons/icon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Movies - Home</title>

</head>

<ul>
    <li><a class="active" href="index.php">Home</a></li>
    <li><a href="addFilm.php">Add Movie</a></li>
<?php
if(isset($_SESSION["username"])){
    echo '<li style="float:right; margin-right:20px;"><a href="logout.php">Logout (' . $_SESSION["username"] . ')</a></li>';
}else{
    echo '<li style="float:right; margin-right:2%;"><a href="login.php">Login</a></li>
    <li style="float:right;"><a href="register.php">Register</a></li>';
}
?>

</ul>
<body>
    <?php

    $db = new DB();
    if (!$db->ok()) {
        echo $db->getError();
    }

    if(isset($_GET["filmName"]) && isset($_GET["watched"])){
        $db -> query("UPDATE UserFilm SET watched=? WHERE fid=(SELECT fid from film where title=?) AND uid=?", [$_GET["watched"],$_GET["filmName"], $_SESSION["uid"]]);
        if(!$db) die("Napaka! ".$db->getError());
        header("Location: index.php");
    }

    if(isset($_GET["remove"])){
        $db -> query('DELETE FROM UserFilm WHERE FID=(SELECT fid FROM film WHERE title=?) AND uid = ?', [$_GET["remove"], $_SESSION["uid"]]);
        if(!$db) die("Napaka! ".$db->getError());
        header("Location: index.php");
    }
    
    if (isset($_SESSION["username"])) {
    
    echo '<label>
        Search bux
        <input id="search-field" type="search" />
        </label>
        <button id="random-movie" value="false">Random movie</button>
        <button id="random-movie-including" value="true">Random movie</button>';

        $query = $db -> query('SELECT title,year,runtime,director,imdb,rt,uf.watched FROM film f inner join UserFilm uf on (uf.fid = f.fid) WHERE uf.uid = ? ORDER BY f.title', [$_SESSION["uid"]]);

        echo '<div style="padding-left:5%; padding-right:10%">
        <table id="tabelOfMovies">
            <th>Movie name</th>
            <th>Director</th>
            <th>Year</th>
            <th>Runtime</th>
            <th>IMDB rating</th>
            <th>RT rating</th>
            <th>Watched</th>
            <th>Remove</th>';
        foreach ($query as $key => $val) {
            echo '<tr>';
                echo '<td>' . $val["title"] . '</td>';
                echo '<td>' . $val["director"] . '</td>';
                echo '<td>' . $val["year"] . '</td>';
                echo '<td>' . $val["runtime"] . ' min</td>';
                echo '<td>' . $val["imdb"] . '</td>';
                echo '<td>' . $val["rt"] . '%</td>';
                echo '<td>';
                echo ($val["watched"])? '<a class="watched" href="index.php?filmName=' . $val["title"]  .'&watched=0"> &#10003 </a>':  '<a class="notWatched" href="index.php?filmName=' . $val["title"]  .'&watched=1"> &#x2717 </a>';
                echo '</td>';
                echo '<td> <a class="notWatched" href="index.php?remove=' . $val["title"]  .'"> &#x2717 </a></td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        $query = $db -> query('SELECT title,year,runtime,director,imdb,rt FROM film');

        echo '<div style="padding-left:5%; padding-right:10%">
        <table style="text-align:centre">
            <th>Movie name</th>
            <th>Director</th>
            <th>Year</th>
            <th>Runtime</th>
            <th>IMDB rating</th>
            <th>RT rating</th>';
            foreach ($query as $key => $val) {
                echo '<tr>';
                echo '<td>' . $val["title"] . '</td>';
                echo '<td>' . $val["director"] . '</td>';
                echo '<td>' . $val["year"] . '</td>';
                echo '<td>' . $val["runtime"] . ' min</td>';
                echo '<td>' . $val["imdb"] . '</td>';
                echo '<td>' . $val["rt"] . '</td>';
                echo '</tr>';
            }
    
        echo '</table>';
    }
    ?>
    <script>
    $("#search-field").keyup(function(){
        $.get("utils/ajaxSearch.php",{   
            query: $(this).val()}, 
            function(data) {
                data = JSON.parse(data)
                $("#tabelOfMovies").html("<th>Movie name</th><th>Director</th><th>Year</th><th>Runtime</th><th>IMDB rating</th><th>RT rating</th><th>Watched</th><th>Remove</th>");
                data.forEach(el => {
                    str = `
                    <tr>
                    <td>${el["title"]}</td>
                    <td>${el["director"]}</td>
                    <td>${el["year"]}</td>
                    <td>${el["runtime"]}</td>
                    <td>${el["imdb"]}</td>
                    <td>${el["rt"]}</td>`;
                    (el["watched"] == 1) ? str += '<td><a class="watched" href="index.php?filmName=' + el["title"]  + '&watched=0"> &#10003 </a></td>': str += '<td><a class="notWatched" href="index.php?filmName=' + el["title"] + '&watched=1"> &#x2717 </a></td>';
                    str += '<td> <a class="notWatched" href="index.php?remove=' + el["title"]  + '"> &#x2717 </a></td>';
                    str += "</tr>"
                    $("#tabelOfMovies").append(str);
                });
            }
        );
    });

    $("#random-movie").click(function(){
        $.get("utils/randomMovie.php",{
            randomMovie: $(this).val()}, 
            function(data) {
                data = JSON.parse(data)
                el = data[0];
                $("#tabelOfMovies").html("<th>Movie name</th><th>Director</th><th>Year</th><th>Runtime</th><th>IMDB rating</th><th>RT rating</th><th>Watched</th><th>Remove</th>");
                str = `
                <tr>
                <td>${el["title"]}</td>
                <td>${el["director"]}</td>
                <td>${el["year"]}</td>
                <td>${el["runtime"]}</td>
                <td>${el["imdb"]}</td>
                <td>${el["rt"]}</td>`;
                (el["watched"] == 1) ? str += '<td><a class="watched" href="index.php?filmName=' + el["title"]  + '&watched=0"> &#10003 </a></td>': str += '<td><a class="notWatched" href="index.php?filmName=' + el["title"] + '&watched=1"> &#x2717 </a></td>';
                str += '<td> <a class="notWatched" href="index.php?remove=' + el["title"]  + '"> &#x2717 </a></td>';
                str += "</tr>"
                $("#tabelOfMovies").append(str);
            }
        );
    });

    $("#random-movie-including").click(function(){
        $.get("utils/randomMovie.php",{
            randomMovie: $(this).val()}, 
            function(data) {
                data = JSON.parse(data)
                el = data[0];
                $("#tabelOfMovies").html("<th>Movie name</th><th>Director</th><th>Year</th><th>Runtime</th><th>IMDB rating</th><th>RT rating</th><th>Watched</th><th>Remove</th>");
                str = `
                <tr>
                <td>${el["title"]}</td>
                <td>${el["director"]}</td>
                <td>${el["year"]}</td>
                <td>${el["runtime"]}</td>
                <td>${el["imdb"]}</td>
                <td>${el["rt"]}</td>`;
                (el["watched"] == 1) ? str += '<td><a class="watched" href="index.php?filmName=' + el["title"]  + '&watched=0"> &#10003 </a></td>': str += '<td><a class="notWatched" href="index.php?filmName=' + el["title"] + '&watched=1"> &#x2717 </a></td>';
                str += '<td> <a class="notWatched" href="index.php?remove=' + el["title"]  + '"> &#x2717 </a></td>';
                str += "</tr>"
                $("#tabelOfMovies").append(str);
            }
        );
    });
    
    </script>
</body>
</html>
