<?php

include 'common.php';

session_start();


function login() {
    if(isset($_POST['submit'])) {
        $un = $_POST['username'];
        $pw = md5($_POST['password']);
        
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
        
        show_nav();
        print '<article>Welcome to the Hackable EMR system. This system was intentionally programmed with 
        some of the worst security problems possible. Even with a non-admin account, you can easily
        get admin access as well as view/upload arbitrary patient information and files.<br><br>It hopefully
        goes without saying, but this system intentionally violates as many HIPAA regulations possible and should
        NEVER be used for storing PHI (Protected Healthcare Information).<br><br>
        Note: All doctors, staff, patients, medical records, images of identification/insurance/credit cards are generated randomly by AI.
        Any likeness to actual people or official documents are purely coincidental. All medical devices shown are simulated.</article>';
        #show_loading_spinner();

    } else {
        login();
    }

    # close html
    close_html();
    exit();
}


main();

?>
