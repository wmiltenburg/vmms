<?php

/**
 * @author Koen Veelenturf
 * @version 1.0
 */

include '../ssh_logins.php';
require_once '../classes/database.class.php';
if(isset($_GET['username'])){

    $user = $_GET['username'];
    $session = $_GET["session"];
    $action = $_GET["action"];

    if (isset($_POST["submit"]) AND (isset($_POST["vm"])) AND ($action == "add" OR $action == "mod")) {
        if ((isset($_POST["vm"])) AND (isset($_POST["user"])) AND (isset($_POST["ipaddress"])) AND (isset($_POST["days"])) AND (isset($_POST["when1"])) ) {
            $vmname = $_POST["vm"];
            $username = $_POST["user"];
            $ipaddress = $_POST["ipaddress"];
            $when1 = $_POST["when1"];
            $when2 = $_POST["when2"];
            $when3 = $_POST["when3"];
            $days = $_POST["days"];
        } else {
          echo "You didn't fill in one of the requirered forms";
        }

    $vmlocation = "/var/lib/libvirt/images/". $vmname .".img";
    $xmllocation = "/etc/libvirt/qemu/". $vmname .".xml";
    $directory = "/backup/" . $vmname;
    $filename = "/etc/backup.d/$vmname.rdiff";
    
    

if (!function_exists("ssh2_connect")) die("function ssh2_connect doesn't exist");

    if(!($con = ssh2_connect("$masterip", 22))){
        echo "Error: Unable to establish connection\n";
    } else {
        // try to authenticate with username root, password secretpassword
        if(!ssh2_auth_password($con, "$ssh_login", "$ssh_password")) {
            echo "fail: unable to authenticate\n";
        } else {
            // allright, we're in!
            echo "okay: logged in... <br/>";
            // execute a command
            if (!($stream = ssh2_exec($con, "sudo /home/team7/public_html/bash_scripts/backupsettings.sh $vmname $username $ipaddress $when1 $days $vmlocation $xmllocation $directory $when2 $when3" ))) {
                echo "Error: Unable to execute command\n";
                header("Location:http://$masterip/~team7/poptions.php?username=$user&session=$session&msg=bsfail");
            } else {
                // collect returning data from command
                $database = new Database();
                $database->openConnection();
                
                if($action == "add") {
                    $sql = sprintf("INSERT INTO backup (vmname, username, location, when1, when2, when3, ipaddress, destinationuser, days) VALUES ('$vmname', '$user', '$filename', '$when1', '$when2', '$when3', '$ipaddress', '$username', '$days')");
                    $database->doQuery($sql);
                    $database->closeConnection();
                }
                
                if($action == "mod") {
                    $sql = "UPDATE backup SET username = '$user', location = '$filename', when1 = '$when1', when2 = '$when2', when3 = '$when3', ipaddress = '$ipaddress', destinationuser = '$username', days = '$days' WHERE vmname = '$vmname'";
                    $database->doQuery($sql);
                    $database->closeConnection();
                }
                stream_set_blocking($stream, true);
                $data = "";
                while ($buf = fread($stream,4096)) {
                    $data .= $buf;

                }
                fclose($stream);
                header("Location:http://$masterip/~team7/poptions.php?username=$user&session=$session&msg=bssucces");
            }
        }
        }
    }
}
    if($_GET["action"] == "del") {
        if(isset($_POST["yes"])) {
        $vm = $_GET["vm"];
            if (!function_exists("ssh2_connect")) die("function ssh2_connect doesn't exist");

                if(!($con = ssh2_connect("$masterip", 22))){
                    echo "Error: Unable to establish connection\n";
                } else {
                    // try to authenticate with username root, password secretpassword
                    if(!ssh2_auth_password($con, "$ssh_login", "$ssh_password")) {
                        echo "fail: unable to authenticate\n";
                    } else {
                        // allright, we're in!
                        echo "okay: logged in... <br/>";
                        // execute a command
                        if (!($stream = ssh2_exec($con, "sudo /home/team7/public_html/bash_scripts/backupdelete.sh $vm" ))) {
                            echo "Error: Unable to execute command\n";
                            header("Location:http://$masterip/~team7/poptions.php?username=$user&session=$session&msg=bdfail");
                        } else {
                            $database = new Database();
                            $database->openConnection();        
                            $sql = sprintf("DELETE FROM backup WHERE vmname = '$vm'");
                            $database->doQuery($sql);
                            $database->closeConnection(); 

                            // collect returning data from command
                            stream_set_blocking($stream, true);
                            $data = "";
                            while ($buf = fread($stream,4096)) {
                                $data .= $buf;

                            }
                            echo $vm;
                            fclose($stream);
                            header("Location:http://$masterip/~team7/poptions.php?username=$user&session=$session&msg=bdsucces");
                        }
                    }
                }        
            }
            if (isset($_POST["no"])) {
                header("Location:http://$masterip/~team7/poptions.php?username=$user&session=$session");
            }
    }

?>
