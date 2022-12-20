<?php

$VERSION = '0.0.1-alpha1';

# ensure user has a valid session
function check_login() {
  if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == True) {
      return True;
  } else {
      return False;
  }
}

function open_html() {
    global $VERSION;
    print "<html>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <head>
        <link rel=stylesheet type=text/css href=style.css>
        <link rel=stylesheet type=text/css href='//fonts.googleapis.com/css?family=Droid+Sans+Mono' />
        <title>HACKEMR - " . $VERSION ."</title>
        <script>
        function verify() {
            if (confirm('Confirm action?')) {
               return true;
            } else {
              return false;
            }
        }
        </script>
        </head>
        <body>
        <header> Hackable EMR </header><section>";
}


function message_box($message, $centered = True) {
  if($centered == True) { print('<center>'); }
  print('<div class="textbox"><h3>' . $message . '</h3></div>');
  if($centered == True) { print('</center>'); }
}

function close_html() {
  print "</section><footer>";
  tip();
  print "</body></html>";
}


function centered_message($str) {
  print "<br><br><center><h4>" . $str  . "<h4></center>";
}

function check_system_disabled() {
  return file_exists('DISABLED');
}

function tip() {
  echo '<br>';
  $SERVER = 'localhost';
  $USER   = 'emr';
  $PASS   = 'password';
  $DBNAME = 'EMR';
  $db = mysqli_connect($SERVER, $USER, $PASS, $DBNAME);
  if(!db) {
    die("Connection failure: " . mysqli_connect_error());
  }
  $query = 'SELECT text from tips order by rand();';
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($result);
  message_box('Tip: ' . $row['text']);
}

function show_nav() {
  print '<nav><ul>
  <button class="button" onclick=\'window.location.href="index.php"\';">Home</button><br>
  <button class="button" onclick=\'window.location.href="lfi.php"\';">Notices</button><br>
  <button class="button" onclick=\'window.location.href="patient.php"\';">Patient Lookup</button><br>
  <button class="button" onclick=\'window.location.href="tip.php"\';">Enter a new tip!</button><br>';
  if($_SESSION['is_admin'] == 1) {
    print '<center><h5>Admin Tools</h5></center><br>
    <button class="button" onclick=\'window.location.href="test.php"\'>User List</button><br>
    <button class="button" onclick=\'window.location.href="testinject.php"\'>User ID Checker</button><br>
    <button class="button" onclick=\'window.location.href="phpmyadmin/index.php"\'>phpMyAdmin</button><br>
    <br><br><br><br><br>';
  }

  print '<button class="button" onclick=\'window.location.href="logoff.php"\'>Logoff</button>';
  print '</ul></nav>';
}

?>