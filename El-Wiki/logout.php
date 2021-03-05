<?php
session_start();
include_once 'lib.php';
if(!isset($_SESSION["id"]))
    header("location: index.php");
session_destroy();
header("location: index.php");
?>