<?php
session_start();
include("db.php");

$db = new DB();
if (!$db->ok()) {
    echo $db->getError();
}

if(isset($_GET["query"])){
    $query = $db -> query('SELECT title,year,runtime,director,imdb,rt,uf.watched FROM film f inner join UserFilm uf on (uf.fid = f.fid) WHERE uf.uid = ? and (title RLIKE ? OR director RLIKE ?)ORDER BY f.title', [$_SESSION["uid"], $_GET["query"], $_GET["query"]]);
    echo json_encode($query);
}
