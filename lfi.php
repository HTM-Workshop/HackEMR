<?php
session_start();
include 'common.php';
if($_SESSION['logged_in'] != True || check_system_disabled()) {
    header('Refresh: 0; URL = index.php');
    exit();
}
open_html();
show_nav();

if(!isset($_GET['file'])) {
    header('Refresh: 0; URL = lfi.php?file=notice.txt');
}

echo '<article><h2><center>Notices:</center></h2><pre>';
echo file_get_contents($_GET['file']);
echo '</pre></article>';

close_html();
?>