<?
/**
 * @author Wouter Miltenburg
 * @version 1.0
  */
?>
<?php

    include 'include/ssh_logins.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><? include 'include/title.php'; ?></title>
        <link rel="stylesheet" href="./css/plaintech.css" type="text/css" />

    </head>
    <body>
<?php
    include 'include/header.php';
    require_once 'include/classes/database.class.php';
?>
 	<div id="body">
<?php


$database = new Database();

$database->openConnection();

    //Kijken of $username en $session wel bestaan
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['vm']) && isset($_GET['command'])){



        $username = $_GET['username'];
        $session = $_GET['session'];
        $vm = $_GET['vm'];
        $command = $_GET['command'];

        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);

        if($database->affectedRows() == 1){
            $query = "SELECT master_ip FROM vm WHERE vm = '$vm'";

            $test = $database->getQuery($query);

            $master_ip = $test['master_ip'];

            //echo "IP: $master_ip <br/>";

            if (!function_exists("ssh2_connect")) die("function ssh2_connect doesn't exist");

                // log in at server1.example.com on port 22
                /*$sql = mysql_query("SELECT master_ip FROM vm WHERE vm = '$vm'");
                $out = mysql_fetch_assoc($sql);
                $ip = $out['master_ip'];
                 *
                 *
                 *
                 */






                if(!($con = ssh2_connect("$master_ip", 22))){
                    echo "fail: unable to establish connection\n";
                } else {
                    // try to authenticate with username root, password secretpassword
                    if(!ssh2_auth_password($con, "$ssh_login", "$ssh_password")) {
                        echo "fail: unable to authenticate\n";
                    } else {
                        // allright, we're in!
                        echo "okay: logged in... <br/>";

                            // execute a command
                            if (!($stream = ssh2_exec($con, "virsh $command $vm > /home/$ssh_login/public_html/info/$command.$vm.txt" ))) {
                            echo "fail: unable to execute command\n";

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


                $file = fopen("/home/$ssh_login/public_html/info/$command.$vm.txt", "r") or exit("Unable to open file!");
                //Output a line of the file until the end is reached
                while(!feof($file))

                    {

                    echo fgets($file). "<br />";


                    }

                    fclose($file);


                    //include "/home/$ssh_login/public_html/info/$command.$vm.txt";

                    //echo "Debug: ip: $master_ip login $ssh_login $ssh_password $command";


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

                } else {
                echo "Username or password is incorrect. Or the session has expired.";
            }
        } else {
            echo "You didn't fill in the form.";
        }
?>
 		</div>
    </body>
</html>