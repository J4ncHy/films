<?php 
session_start();
include("sessionsSettings.php");

if(isset($_SESSION["username"])){
    unset($_SESSION["username"]);
    if(isset($_SESSION["uid"]))
        unset($_SESSION["uid"]);
    header("Location: index.php");
}
?>