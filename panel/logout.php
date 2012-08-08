<?php
include_once '../config.php';
if((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) { header("Locatin: index.php"); }

session_destroy();
header("Location: index.php");