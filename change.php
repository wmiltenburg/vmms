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
    require_once 'include/classes/database.class.php';
?>
   	<div id="body"> 
            <?php

    include 'include/ssh_logins.php';
?>
<?php
    $username = $_GET['username'];
    $session = $_GET['session'];
    $user = $_GET['user'];
    $database = new Database();
    $database->openConnection();
    if($_POST["password"] == "" && $_POST["password2"] == ""){
        header("Location:http://$masterip/~team7/edit.php?username=$username&session=$session&user=$user&msg=error");
    } else {

    //Check if the username matches with the session
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['user']) && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['name']) && isset($_POST['lname']) && isset($_POST['mail']) && isset($_POST['phone']) && isset($_POST['rights'])){

        $login = $_POST['login'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $name = $_POST['name'];
        $lname = $_POST['lname'];
        $mail = $_POST['mail'];
        $phone = $_POST['phone'];
        $sla = $_POST['sla'];
        $rights = $_POST['rights'];


        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);
        
        if($database->affectedRows() == 1){
            echo "Logged in as: $username <br/>";
                
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
                             if (!($stream = ssh2_exec($con, "sudo htpasswd -b /usr/local/nagios/etc/htpasswd.users $user $password" ))) {
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
            
                $query = "UPDATE admin SET username = '$login', password = '$password3', name = '$name', lname = '$lname', mail = '$mail', phone = '$phone', sla = '$sla', rights = '$rights' WHERE username = '$user'";
                $database->doQuery($query);
            

            
                echo "User $user is updated to $login<br />";
            
                echo "<br />";
            
                			   	echo "<table id=\"options1\"><td>Go back to your dashboard: </td>
				<td>
					<div id=\"optionslink\">
						<a href=\"./poptions.php?username=$username&session=$session\">
							<INPUT TYPE=\"button\" VALUE=\"Click here\" Class=\"knop\">
						</a>
					</div>
				</td>
				</table>";

			   echo "<br />";

			 	echo "<table id=\"options1\"><td>Logout: </td>
				<td>
					<div id=\"optionslink\">
						<a href=\"./logout.php?username=$username&session=$session\">
							<INPUT TYPE=\"button\" VALUE=\"Click here\" Class=\"knop\">
						</a>
					</div>
				</td>
				</table><br />";


            }else{
                echo "Passwords don't match";
            }
        } else {
            echo "Username or password is incorrect. Or the session has expired.";
        }

    } else {
        echo "You didn't fill in the form.";
    }
    $database->closeConnection();
    }
?>
     		</div>
    </body>
</html>