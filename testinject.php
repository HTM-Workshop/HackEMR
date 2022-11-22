<?php
session_start();
include 'common.php';
open_html();
show_nav();


if($_SESSION['logged_in'] != True || check_system_disabled()) {
    header('Refresh: 0; URL = index.php');
    exit();
}

print '<center>
    <br><br>Check the owner of a user id:<br>
    <form method="post">
    <input name="id" type=text placeholder="id" required><br>
    <input name="submit" class="buttonlogin" type="submit" value="Submit"></h1></input>
    </form>
</center>';

$SERVER = 'localhost';
$USER   = 'emr';
$PASS   = 'password';
$DBNAME = 'EMR';

if(isset($_POST['submit'])) {
    $db = mysqli_connect($SERVER, $USER, $PASS, $DBNAME);
    if(!db) {
        die("Connection failure: " . mysqli_connect_error());
    }
    $id = $_POST['id'];
    $query = "SELECT username from users where id = '$id';";
    $result = mysqli_query($db, $query);

    print("<center><h2>Result:</h2></center>");
    while($row = mysqli_fetch_assoc($result)) {
        $uname = $row['username'];
        echo "<center><pre>User name: $uname <pre></center>";
    }

}



close_html();
?>