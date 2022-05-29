<?php
session_start();
include("db.php");

$db = new DB();
if (!$db->ok()) {
    echo $db->getError();
}

//print_r($_GET);

if(isset($_GET["randomMovie"])){
    // TODO including   
    if ($_GET["randomMovie"] == "true")
        $query = $db -> query('SELECT f.title,f.year,f.runtime,f.director,f.imdb,f.rt,uf.watched FROM film f inner join UserFilm uf on (uf.fid = f.fid) WHERE uf.uid = ? ORDER BY rand() limit 1', [$_SESSION["uid"]]);
    else if ($_GET["randomMovie"] == "false")
        $query = $db -> query('SELECT f.title,f.year,f.runtime,f.director,f.imdb,f.rt,uf.watched FROM film f inner join UserFilm uf on (uf.fid = f.fid) WHERE uf.watched = 0 AND uf.uid = ? ORDER BY rand() limit 1', [$_SESSION["uid"]]);
    

    echo json_encode($query);
}