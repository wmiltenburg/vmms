<?php
require_once '../ssh_logins.php';

/**
 * @author Koen Veelenturf
 * @version 1.0
 */

$username = $_GET["username"];
$session = $_GET["session"];
$location = $_GET["location"];
if (!function_exists("ssh2_connect")) die("function ssh2_connect doesn't exist");

    if(!($con = ssh2_connect("$masterip", 22))){
        echo "Error: Unable to establish connection\n";
    } else {
        // try to authenticate with username root, password secretpassword
        if(!ssh2_auth_password($con, "$ssh_login", "$ssh_password")) {
            echo "fail: unable to authenticate\n";
        } else {
            // allright, we're in!
            echo "Okay: Logged in... <br/>";
            // execute a command
            if (!($stream = ssh2_exec($con, "sudo /home/team7/public_html/bash_scripts/nconf_update.sh" ))) {
                echo "Error: Unable to execute command\n";
               header("Location:http://$masterip/~team7/poptions.php?username=$username&session=$session");
            } else {
                // collect returning data from command
                stream_set_blocking($stream, true);
                $data = "";
                while ($buf = fread($stream,4096)) {
                    $data .= $buf;
                    echo "Nagios rebooted";
                    
                }
                fclose($stream);
               header("Location:http://$masterip/~team7/poptions.php?username=$username&session=$session");

            }
        }
    }
?>
