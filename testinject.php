<?php
session_start();
include 'common.php';


if($_SESSION['logged_in'] != True || check_system_disabled()) {
    header('Refresh: 0; URL = index.php');
    exit();
}

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


    while($row = mysqli_fetch_assoc($result)) {
        $uname = $row['username'];
        echo "User name: $uname <br>";
    }

}

print '<center>
    <a href="index.php">Back to main page</a>
    <br><br><h4>Restricted Access: Authorized Users Only</h4>
    <div style="width:400px;">
    <form method="post">
    <input name="id" type=text placeholder="id" required><br>
    <input name="submit" class="buttonlogin" type="submit" value="Submit"></h1></input>
    </form>
    </div>
</center>';


?>