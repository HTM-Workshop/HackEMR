<?php
session_start();
include 'common.php';
if($_SESSION['logged_in'] != True || check_system_disabled()) {
    header('Refresh: 0; URL = index.php');
    exit();
}
open_html();
show_nav();

print '<article><blockquote><center>
    <br><br>Enter a new helpful tip here:<br>
    <form method="post">
    <textarea name="text" type=text class="comment" required></textarea><br>
    <input name="submit" class="buttonlogin" type="submit" value="Submit"></h1></input>
    </form>
</center>';

$SERVER = 'localhost';
$USER   = 'emr';
$PASS   = 'password';
$DBNAME = 'EMR';

echo '<center><h2>Current tips: <br></h2></center>';
$db = mysqli_connect($SERVER, $USER, $PASS, $DBNAME);
if(!$db) {
    die("Connection failure: " . mysqli_connect_error());
}
if(isset($_POST['submit'])) {
    $text = $_POST['text'];
    $query = "INSERT INTO tips (text) VALUES (\"$text\");";
    $result = mysqli_query($db, $query);
}
$query = "SELECT * from tips;";
$result = mysqli_query($db, $query);
echo '</center><table><tr><th>ID</th><th>Text</th></tr>';
while($row = mysqli_fetch_assoc($result)) {
    echo '<tr><td>';
    $id = $row['id'];
    echo "$id";
    echo '</td><td>';
    $text = $row['text'];
    echo "$text";
    echo '</td></tr>';
}
echo '</table></blockquote></center>';
close_html();
?>
