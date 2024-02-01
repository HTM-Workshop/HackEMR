<?php
session_start();
include 'common.php';
open_html();
show_nav();

if($_SESSION['logged_in'] != True || check_system_disabled()) {
    header('Refresh: 0; URL = index.php');
    exit();
}
if($_SESSION['is_admin'] != 1) {
    echo '<center><h1>Access Denied</h1>';
    echo '<img src="img/drevil.jpeg">';
    exit();
}

echo "<center><h3>User List </h3></center>";
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
        <style type="text/css">
            tr.header
            {
                font-weight:bold;
            }
            tr.alt
            {
                background-color: #CCCCCC;
            }
			td
			{
				padding:0 15px 0 15px;
			}
        </style>
        <script type="text/javascript">
            $(document).ready(function(){
               $(\'.striped tr:even\').addClass(\'alt\');
            });
        </script>
        <title></title>
    <body>
		<br>
        <table class="striped" align=center>
            <tr class="header">
                <td>ID</td>
                <td>User Name</td>
                <td>Enabled</td>
                <td>Reg Time BPM</td>
                <td>Is Admin</td>
            </tr>';

$SERVER = 'localhost';
$USER   = 'emr';
$PASS   = 'password';
$DBNAME = 'EMR';

$db = mysqli_connect($SERVER, $USER, $PASS, $DBNAME);
if(!$db) {
	die("Connection failure: " . mysqli_connect_error());
}

$query = 'SELECT * FROM users;';
$result = mysqli_query($db, $query);

if(mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	//	echo "ID: " . $row["patient_id"] . " - FNAME: " . $row["first_name"] . " - LNAME: " . $row["last_name"] . "<br>";
		echo "<tr>";
		echo "<td>" . $row["id"] . "</td>";
		echo "<td>" . $row["username"] . "</td>";
		echo "<td>" . $row["enabled"] . "</td>";
		echo "<td>" . $row["regtime"] . "</td>";
		echo "<td>" . $row["is_admin"] . "</td>";
		echo "</tr>";
	}
} else {
	echo "No results.";
}

echo '</table>';
close_html();
?>
