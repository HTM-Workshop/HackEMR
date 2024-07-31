<?php
session_start();
include 'common.php';
if((isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == True) || check_system_disabled()) {
    header("Refresh: 0; URL=logoff.php");
    exit();
}
open_html();

# any fail condition during registration needs exit the script
function reg_fail($message) {
    unset($_POST);
    centered_message($message);
    header("Refresh: 3; URL=#");
    close_html();
    exit();
}

function register() {
    if(isset($_POST['submit'])) {
        $un      = $_POST['username'];
        $raw_pw  = $_POST['password'];
        $raw_cpw = $_POST['confirm_password'];
        $SERVER = 'localhost';
        $USER   = 'emr';
        $PASS   = 'password';
        $DBNAME = 'EMR';
        
        # check if username is valid
        if(ctype_alnum($un) == False || strlen($un) > 32) { reg_fail("Invalid username"); }
        
        # check if username already exists (function returns true (1) if username already exists in database)
        $db = mysqli_connect($SERVER, $USER, $PASS, $DBNAME);
        if ( mysqli_connect_errno() ) {
            // If there is an error with the connection, stop the script and display the error.
            exit('Failed to connect to MySQL: ' . mysqli_connect_error());
        }
        if($query = $db->prepare('SELECT username from users where username = ?')) {
            $query->bind_param('s', $_POST['username']);
            $query->execute();
            $query->store_result();
            if($query->num_rows != 0) {
                reg_fail("Username already taken");
            }
            $query->close();
        }

        # check if password meets length requirements
        $pw_len = strlen($raw_pw);
        if($pw_len > 32) { reg_fail("Password outside of length constrants"); }

        # check if password and confirm_password are the same
        $pw = $raw_pw;
        $cpw = $raw_cpw;
        if($pw != $cpw) { reg_fail("Passwords do not match"); }

        # account information checks out, add to database and return to index.php
        if($query = $db->prepare('INSERT INTO users (username, password, enabled) VALUES (?, ?, 1)')) {
            $query->bind_param('ss', $un, md5($pw));
            $query->execute();
            $query->store_result();
            $query->close();
            centered_message("Account creation successful");
        }
        

    } else {
        print '<center>
            <br><br><h4>User Registration</h4>
            <div style="width:400px;">
            <form method="post">
            <input name="username" type=username placeholder="Username" required><br>
            <input name="password" type=password placeholder="Password (8-32 characters)" required><br>
            <input name="confirm_password" type=password action=submit placeholder="Confirm Password" required><br>
            <input name="submit" class="buttonlogin" type="submit" value="Submit"></h1></input>
            </form>
            </div>';
        message_box('NOTICE: Registration is only for Doctors, Nursing staff, or anyone else with valuable information to be stolen.');
    }
}

register();

?>
