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
   if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['login']) && isset($_POST['vm']) && isset($_POST['ram']) && isset($_POST['cpu']) && isset($_POST['hdd']) && isset($_POST['os']) && isset($_POST['ip']) && isset($_POST['ip_master'])){



        $username = $_GET['username'];
        $session = $_GET['session'];
        $login = $_GET['login'];
        $vm = $_POST['vm'];
        $ram = $_POST['ram'];
		$cpu = $_POST['cpu'];
        $hdd = $_POST['hdd'];
        $os = $_POST['os'];
        //$sla = $_POST['sla'];
        $ip = $_POST['ip'];
        $ip_master = $_POST['ip_master'];

        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);

        if($database->affectedRows() == 1){
            //$query = "SELECT master_ip FROM vm WHERE vm = '$vm'";
            echo "<br/>Logged in as: $username <br/>";

            echo "<br/><b>Step 2 of 3</b> <br/>";


        $query = "SELECT vm FROM vm WHERE vm = '$vm'";
        $database->getQuery($query);

        if($database->affectedRows() != 1){
            //echo "IP: $master_ip <br/>";

            //Check the os_dir
            $query_os = "SELECT path FROM os_dir WHERE os = '$os'";
            $temp = $database->getQuery($query_os);
            $os_dir = $temp['path'];
            echo "<br/>OS DIR: $os_dir <br/>";

            if (!function_exists("ssh2_connect")) die("function ssh2_connect doesn't exist");

                // log in at server1.example.com on port 22
                /*$sql = mysql_query("SELECT master_ip FROM vm WHERE vm = '$vm'");
                $out = mysql_fetch_assoc($sql);
                $ip = $out['master_ip'];
                 *
                 *
                 *
                 */






                if(!($con = ssh2_connect("$ip_master", 22))){
                    echo "fail: unable to establish connection\n";
                } else {
                    // try to authenticate with username root, password secretpassword
                    if(!ssh2_auth_password($con, "$ssh_login", "$ssh_password")) {
                        echo "fail: unable to authenticate\n";
                    } else {
                        // allright, we're in!
                        echo "<br/>okay: logged in... <br/>";

                            // execute a command
                            if (!($stream = ssh2_exec($con, "/home/$ssh_login/public_html/bash_scripts/copy.sh $os_dir $vm > /home/$ssh_login/public_html/info/copy_vm.$vm.txt" ))) {
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





                //echo "virt-install --connect qemu:///system -n $vm -r $ram --vcpus=1 --disk path=/var/lib/libvirt/images/$vm.img,size=$hdd -c $os_dir --vnc --noautoconsole --os-type linux --accelerate --network=bridge:br0 --hvm";
                $file = fopen("/home/$ssh_login/public_html/info/copy_vm.$vm.txt", "r") or exit("Unable to open file!");
                //Output a line of the file until the end is reached

                echo "<br/>The next step, install the vm: <a href=\"vm_ssh_add.php?username=$username&session=$session&login=$login&vm=$vm&ram=$ram&cpu=$cpu&hdd=$hdd&os=$os&ip=$ip&ip_master=$ip_master\"><INPUT TYPE=\"button\" VALUE=\"Create\" Class=\"knop\"></a>";
                while(!feof($file))

                    {

                    echo fgets($file). "<br />";


                    }

                    fclose($file);


                    //include "/home/$ssh_login/public_html/info/$command.$vm.txt";

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
                    echo "VM name already exists. It must be an unique name";
                }

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