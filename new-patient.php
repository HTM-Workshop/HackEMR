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

echo '<br><br>';
echo '<form action="new-patient.php" method="get">
First Name: <br><input type="text" name="fname"><br>
Last Name: <br><input type="text" name="lname"><br>
Age: <br><input type="text" name="age"><br>
Weight: <br><input type="text" name="weight"><br>
<input type="submit">
</form>';

if($_SERVER["REQUEST_METHOD"] == "GET") {
	if(empty($_GET["fname"])) {
		echo 'first name required';
		return;
	}
	
	if(empty($_GET["lname"])) {
		echo 'last name required';
		return;
	}
	if(empty($_GET["age"])) {
		echo 'age required';
		return;
	}
	if(empty($_GET["weight"])) {
		echo 'weight required';
		return;
	}
	$fname  = $_GET["fname"];
	$lname  = $_GET["lname"];
	$age    = $_GET["age"];
	$weight = $_GET["weight"];
	$db = mysqli_connect($SERVER, $USER, $PASS, $DBNAME);
	$query = "INSERT INTO patients (first_name, last_name, weight, age) VALUES ('$fname', '$lname', '$weight', '$age');";
	$result = mysqli_query($db, $query);
}


?>
