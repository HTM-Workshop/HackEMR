<?php
include "common.php";
session_start();
open_html();
show_nav();

if($_SESSION['logged_in'] != True || check_system_disabled()) {
    header('Refresh: 0; URL = index.php');
    exit();
}

print '<div class=\'parent\'>
<div class=\'child inline-block-child\'>
    <br><br>Patient ID:</h1><br>
    <form method="post">
    <input name="id" type=text placeholder="id" required><br>
    <input name="submit" class="buttonlogin" type="submit" value="Search"></input>
    </form></div>';

$SERVER = 'localhost';
$USER   = 'emr';
$PASS   = 'password';
$DBNAME = 'EMR';

if(isset($_POST['submit']) && isset($_POST['id'])) {
    $_SESSION['patient_view'] = $_POST['id'];
}

if(isset($_POST['close'])) {
	unset($_POST['id']);
	unset($_SESSION['patient_view']);
}

if(isset($_POST['submit']) && isset($_FILES["fileToUpload"]["tmp_name"])) {
    $target_dir = "patient_files/" . $_SESSION['patient_view'] . "/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    header('Refresh: 2');
}

if(isset($_POST['patient_select'])) {
    $_SESSION['patient_view'] = $_POST['patient_select'];
}

if(isset($_SESSION['patient_view'])) {
    $db = mysqli_connect($SERVER, $USER, $PASS, $DBNAME);
    if(!$db) {
        die("Connection failure: " . mysqli_connect_error());
    }
    $id = $_SESSION['patient_view'];
    $output = null;
    $retval = null;
    exec("mkdir -p patient_files/$id", $output, $retval);
    $query = "SELECT * from patients where id = '$id';";
    $result = mysqli_query($db, $query);

    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $weight = $row['weight'];
    $age = $row['age'];
    echo '<div class=\'child inline-block-child\'>


    <form method="post">
    <input type="submit" value="Close Patient Record" name="close">
    </form>

    <form action="patient.php" method="post" enctype="multipart/form-data">
    <pre>Upload file to patient record:</pre>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload" name="submit">
    </form></div></div>';
    print("<article><blockquote><center><h2>Patient Information:</h2></center>");
    echo "<img src=patient_files/$id/profile.png width='200' height='200'>";
    echo "<pre>First Name: $first_name</pre>";
    echo "<pre>Last Name: $last_name</pre>";
    echo "<pre>Weight: $weight</pre>";
    echo "<pre>Age: $age</pre>";
    echo "<hr>Patient Files:<br>";
    $fileList = glob('patient_files/' . $_SESSION['patient_view'] . '/*');
    foreach($fileList as $filename){
        echo "<a href='$filename' target='_blank'>$filename</a><br>";
    }
    echo '</blockquote></article>';
} else {
    $db = mysqli_connect($SERVER, $USER, $PASS, $DBNAME);
    if(!$db) {
        die("Connection failure: " . mysqli_connect_error());
    }
    echo '<button onclick=\'window.location.href="new-patient.php"\';">Add Patient</button><br>';
    echo "<br><b>Patients on file:</b><hr>";
    $query = "SELECT * from patients;";
    $result = mysqli_query($db, $query);
    print '<form method="post">';
    echo '</center><table><tr><th>ID</th><th>Last Name</th><th>First Name</th><th>Link</th></tr>';   
    while($row = mysqli_fetch_assoc($result)) {
        echo '<tr><td>';
	echo $row['id'];
        echo '</td><td>';
	echo $row['last_name'];
	echo '</td><td>';
	echo $row['first_name'];
	echo '</td><td>';
	$id = $row['id'];
	echo "<input name=\"patient_select\" type=\"submit\" value=\"$id\" name=\"$id\"></input>";
	echo '</td></tr>';
    }
    echo '</table></blockquote></center></form>';
}


close_html();
?>
