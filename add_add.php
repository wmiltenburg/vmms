<?
/**
 * @author Wouter Miltenburg
 * @version 1.0
  */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php include 'include/title.php'; ?></title>
        <link rel="stylesheet" href="./css/plaintech.css" type="text/css" />
    </head>
    <body>

<?php
    include 'include/header.php';
?>
    <div id="body">
        <?php

    include 'include/ssh_logins.php';
?>
<?php
    // Including the database class
    require_once('include/classes/database.class.php');

    // Creating database instance
    $database = new Database();
    $database->openConnection();

    //Kijken of $username en $session wel bestaan
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['sla']) && isset($_POST['name']) && isset($_POST['lname']) && isset($_POST['mail']) && isset($_POST['phone']) && isset($_POST['rights'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $login = $_POST['login'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $sla = $_POST['sla'];
        $name = $_POST['name'];
        $lname = $_POST['lname'];
        $mail = $_POST['mail'];
        $phone = $_POST['phone'];
        $rights = $_POST['rights'];



//Kijken of de session overeenkomt met de username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);
        if($database->affectedRows() == 1) {

            echo "<br/>Logged in as: $username <br/>";
            $query = "SELECT username FROM admin WHERE username = '$login'";
            $database->getQuery($query);
            if($database->affectedRows() != 1){

                if($password==$password2){
                $password3= sha1($password);
                if (!function_exists("ssh2_connect")) die("function ssh2_connect doesn't exist");

                // log in at server1.example.com on port 22
                /*$sql = mysql_query("SELECT master_ip FROM vm WHERE vm = '$vm'");
                $out = mysql_fetch_assoc($sql);
                $ip = $out['master_ip'];
                 *
                 *
                 *
                 */






                if(!($con = ssh2_connect("$masterip", 22))){
                    echo "fail: unable to establish connection\n";
                } else {
                    // try to authenticate with username root, password secretpassword
                    if(!ssh2_auth_password($con, "$ssh_login", "$ssh_password")) {
                        echo "fail: unable to authenticate\n";
                    } else {
                        // allright, we're in!
                        echo "<br/>okay: logged in... <br/>";

                            // execute a command
                             if (!($stream = ssh2_exec($con, "sudo htpasswd -b /usr/local/nagios/etc/htpasswd.users $login $password" ))) {
                            echo "<br/>fail: unable to execute command\n";

                            } else {
                                // collect returning data from command
                                stream_set_blocking($stream, true);
                                $data = "";
                                while ($buf = fread($stream,4096)) {
                                    $data .= $buf;

                                }
                                fclose($stream);
                            }
                    }
                }

                //Create a user in table admin
                $query = sprintf("INSERT INTO admin (username, password, sla, name, lname, mail, phone, rights) VALUES ('$login', '$password3', '$sla', '$name', '$lname', '$mail', '$phone', '$rights')");
                $affectedRows = $database->doQuery($query);

                echo "<br/>User $login is added<br />";

                } else{
                echo "Passwords don't match";
                }

            } else{
                echo "User $login already exists.";

            }
				echo "<br /><br />";
				echo "<div id=\"dashboard\">
                        <a href=\"./poptions.php?username=$username&session=$session\">
                            <INPUT TYPE=\"button\" VALUE=\"Dashboard\" Class=\"knop\">
                        </a>
                      </div>
                <br/>";

				echo "<div id=\"logout\">
                        <a href=\"./logout.php?username=$username&session=$session\">
                            <INPUT TYPE=\"button\" VALUE=\"Logout\" Class=\"knop\">
                        </a>
                      </div>
                <br/>";

        } else{
        echo "Username or password is incorrect. Or the session has expired.";
        }

    }else{
        echo "You didn't fill in the form.";

    }
    $database->closeConnection();
?>


    </div>
    </body>
</html>