<?php
include 'common.php';
session_start();
$_SESSION['logged_in'] = False;
unset($_POST);
$_SESSION = array();
header('Refresh: 0; URL = index.php');
session_destroy();
open_html();
close_html();
?>
