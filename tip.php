<?php
session_start();
include 'common.php';
if($_SESSION['logged_in'] != True || check_system_disabled()) {
    header('Refresh: 0; URL = index.php');
    exit();
}
open_html();

$SERVER = 'localhost';
$USER   = 'emr';
$PASS   = 'password';
$DBNAME = 'EMR';

echo '<center><a href="index.php">Back to main page</a></center>';
echo '<center><h2>Current tips: <br></h2></center>';
$db = mysqli_connect($SERVER, $USER, $PASS, $DBNAME);
if(!db) {
    die("Connection failure: " . mysqli_connect_error());
}
$query = "SELECT * from tips;";
$result = mysqli_query($db, $query);
while($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $text = $row['text'];
    message_box("$id: $text");
}

close_html();
?>