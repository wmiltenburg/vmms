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
        <title><? include 'include/title.php'; ?></title>
        <link rel="stylesheet" href="./css/plaintech.css" type="text/css" />
    </head>
<body>
<?php
    include 'include/header.php';
    require_once 'include/classes/database.class.php';
?>
    <?php

    include 'include/ssh_logins.php';
?>
    	<div id="body">
<?php

    $database = new Database();
    $database->openConnection();

    //Kijken of $username en $session wel bestaan
    if(isset($_GET['username']) && isset($_GET['session'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $vm_old = $_GET['vm_old'];
        //$vm_new = $_GET['vm_new'];
        $login = $_GET['login'];
        $ram = $_GET['ram'];
        $cpu = $_GET['cpu'];
        $hdd = $_GET['hdd'];
        $ip = $_GET['ip'];
        $master_ip = $_GET['master_ip'];
        $os = $_GET['os'];
        //$sla = $_GET['sla'];

        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);
        echo "Logged in as: $username <br/>";

        if($database->affectedRows() == 1){
            
            $query6 = "SELECT * FROM vm WHERE vm = '$vm_old'";
            $temp = $database->getQuery($query6);
            $hdd_old = $temp['hdd'];
            $masterip = $temp['master_ip'];
            if($hdd_old==$hdd){
                
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
                             if (!($stream = ssh2_exec($con, "sudo /home/team7/public_html/bash_scripts/edit_vm.sh $vm_old $ram $cpu $hdd > /home/$ssh_login/public_html/info/edit_vm.$vm.txt" ))) {
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

            echo "How to edit the Virtual Machine:<br />";
            
            //echo "Debug: sudo /home/team7/public_html/bash_scripts/edit_vm.sh $vm_old $ram $cpu $hdd > /home/$ssh_login/public_html/info/edit_vm.$vm.txt";

            $ram_new = $ram*1024;
            echo "Login into the virtual machine and use this command: nano /etc/libvirt/qemu/$vm_old.xml <br/>";
            echo "Change the memory tags to $ram_new <br/>";
            echo "Change the cpu tags to $cpu <br/>";
            echo "If the client wants more space for his harddrive he needs to reinstall his server <br/>";
            echo "Then you create a new virtual machine for the custome. And it needs to be installed with the correct operating system. <br/>";

            $query = sprintf("UPDATE vm SET ram = '$ram', cpu = '$cpu', hdd = '$hdd', ip = '$ip', master_ip = '$master_ip', os = '$os' WHERE vm = '$vm_old' ");
            $database->doQuery($query);
            echo "The order is updated into the database. <br/>";

            $query2 = sprintf("DELETE FROM user_vm_edit WHERE username = '$login'");
            $database->doQuery($query2);
            echo "The order is removed. <br/>";

            
            


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
                                
            }else{
                echo "VM needs to be reinstalled.";
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
            }
                                
                                
                                
        } else {
        echo "Username or password is incorrect. Or the session has expired.";
        }

    } else {
    echo "You didn't fill in the form.";
    }
    $database->closeConnection();
?>


		</div>
    </body>
</html>