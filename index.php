<?php

include 'common.php';

session_start();

# ensure user has a valid session
function check_login() {
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == True) {
        return True;
    } else {
        return False;
    }
}

function login() {
    if(isset($_POST['submit'])) {
        $un = $_POST['username'];
        $pw = $_POST['password'];
        
        # open connection to database and submit query
        $SERVER = 'localhost';
        $USER   = 'emr';
        $PASS   = 'password';
        $DBNAME = 'EMR';
        $db = mysqli_connect($SERVER, $USER, $PASS, $DBNAME);
        if ( mysqli_connect_errno() ) {
            // If there is an error with the connection, stop the script and display the error.
            exit('Failed to connect to MySQL: ' . mysqli_connect_error());
        }
        if($query = $db->prepare('SELECT password, is_admin, enabled from users where username = ?')) {
            $query->bind_param('s', $_POST['username']);
            $query->execute();
            $query->store_result();
        }
        
        if($query->num_rows == 1) {
            $query->bind_result($dbpass, $is_admin, $is_enabled);
            $query->fetch();
            if($pw === $dbpass) {
                if($is_enabled == 0) {
                    print '<center><br><br><h2>Account Disabled</h2><br>';
                    print '<center><a href="index.php">Return to login page</a></center>';
                    close_html();
                    exit();
                }

                # user is authenticated
                $_SESSION["logged_in"] = True;
                $_SESSION["page"] = "overview";
                $_SESSION["last_action"] = time();
                $_SESSION["is_admin"] = $is_admin;
                header("Refresh: 0");
                exit();
            } else {
                print '<center>Incorrect Username or Password</center>';
            }          
        } else {
            print '<center>Incorrect Username or Password</center>';
        }
    }
    print '<center>
        <br><br><h4>Restricted Access: Authorized Users Only</h4>
        <div style="width:400px;">
        <form method="post">
        <input name="username" type=username placeholder="Username" required><br>
        <input name="password" type=password action=submit placeholder="Password" required><br>
        <input name="submit" class="buttonlogin" type="submit" value="Submit"></h1></input>
        </form>
        </div>
        <a>Your IP Address: ' . $_SERVER['REMOTE_ADDR'] . '</a><br>
        <a href="register.php">Register</a></center>';
          #<a href="register.php">Register</a> - <a href="forgot.php">Reset Password</a></center>'
}


function main() {

    # open html
    open_html();

    # check system enabled
    if(check_system_disabled()) {
        message_box('<center><b>OFFLINE<br><br></b>HACKABLE EMR is currently offline</center>');
        exit();
    }

    # check if user is logged in and session is valid
    if(check_login() == True) {
        
        # main functionality
        centered_message("Successfully logged in");
        print '<br><center>
            <a href="tip.php" class="button">Enter a new tip!</a><br>
            <a href="test.php" class="button">Admin DB Access</a><br>
            <a href="testinject.php" class="button">User ID Checker</a><br>
            <a href="phpmyadmin/index.php" class="button">phpMyAdmin</a><br><br>
            <a href="logoff.php" class="button">Logoff</a>
            ';
        #show_loading_spinner();

    } else {
        login();
    }

    # close html
    tip();
    close_html();
    exit();
}


main();

?>