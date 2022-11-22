<?php
include "common.php";
session_start();
open_html();
show_nav();

if($_SESSION['logged_in'] != True || check_system_disabled()) {
    header('Refresh: 0; URL = index.php');
    exit();
}

print '<center>
    <br><br>Patient ID:<br>
    <form method="post">
    <input name="id" type=text placeholder="id" required><br>
    <input name="submit" class="buttonlogin" type="submit" value="Submit"></h1></input>
    </form>
</center>';

$SERVER = 'localhost';
$USER   = 'emr';
$PASS   = 'password';
$DBNAME = 'EMR';

if(isset($_POST['submit']) && isset($_POST['id'])) {
    $_SESSION['patient_view'] = $_POST['id'];
}

if(isset($_POST['submit']) && isset($_FILES["fileToUpload"]["tmp_name"])) {
    $target_dir = "patient_files/" . $_SESSION['patient_view'] . "/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    header('Refresh: 2');
}

if(isset($_SESSION['patient_view'])) {
    $db = mysqli_connect($SERVER, $USER, $PASS, $DBNAME);
    if(!db) {
        die("Connection failure: " . mysqli_connect_error());
    }
    $id = $_SESSION['patient_view'];
    $query = "SELECT * from patients where id = '$id';";
    $result = mysqli_query($db, $query);

    $row = mysqli_fetch_assoc($result);
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $weight = $row['weight'];
    $age = $row['age'];
    echo'<blockquote>
    <form action="patient.php" method="post" enctype="multipart/form-data">
    <pre>Upload file to patient record:</pre>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload" name="submit">
    </form><br>';
    print("<center><h2>Patient Information:</h2></center>");
    echo "<pre>First Name: $first_name</pre>";
    echo "<pre>Last Name: $last_name</pre>";
    echo "<pre>Weight: $weight</pre>";
    echo "<pre>Age: $age</pre>";
    echo "<hr>Patient Files:<br>";
    $fileList = glob('patient_files/' . $_SESSION['patient_view'] . '/*');
    foreach($fileList as $filename){
        echo "<a href=$filename>$filename</a><br>";
    }
    echo '</blockquote>';
}

close_html();
?>