<?php
include "common.php";
session_start();
open_html();
show_nav();

if($_SESSION['logged_in'] != True || check_system_disabled()) {
    header('Refresh: 0; URL = index.php');
    exit();
}

$SERVER = 'localhost';
$USER   = 'emr';
$PASS   = 'password';
$DBNAME = 'EMR';



?>