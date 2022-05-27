<?php 
session_start();
include("sessionsSettings.php");

if(isset($_SESSION["username"])){
    unset($_SESSION["username"]);
    header("Location: index.php");
}
?>