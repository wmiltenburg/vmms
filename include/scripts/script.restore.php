<?php

/**
 * @author Koen Veelenturf
 * @version 1.0
 */
require_once '../ssh_logins.php';
if(isset($_GET["action"])) {
    $username = $_GET["username"];
    $session = $_GET["session"];
    $vmname = $_GET["vmname"];
    $ipaddress = $_GET["ipaddress"];
    $action = $_GET["action"];
    if($action == "restore") {
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
                    if (!($stream = ssh2_exec($con, "sudo /home/team7/public_html/bash_scripts/backuprestore.sh $vmname $ipaddress" ))) {
                        echo "Error: Unable to execute command\n";
                        header("Location:http://$masterip/~team7/poptions.php?username=$username&session=$session&msg=rfail");
                    } else {
                        // collect returning data from command
                        stream_set_blocking($stream, true);
                        $data = "";
                        while ($buf = fread($stream,4096)) {
                            $data .= $buf;
                            echo "Back-up finished";

                        }
                        fclose($stream);
                        header("Location:http://$masterip/~team7/poptions.php?username=$username&session=$session&msg=rsucces");

                    }
                }
            }
        }
}
?>
