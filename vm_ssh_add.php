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
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['login']) && isset($_GET['vm']) && isset($_GET['ram']) && isset($_GET['cpu']) && isset($_GET['hdd']) && isset($_GET['os']) && isset($_GET['ip']) && isset($_GET['ip_master'])){



        $username = $_GET['username'];
        $session = $_GET['session'];
        $login = $_GET['login'];
        $vm = $_GET['vm'];
        $ram = $_GET['ram'];
		$cpu = $_GET['cpu'];
        $hdd = $_GET['hdd'];
        $os = $_GET['os'];
        //$sla = $_POST['sla'];
        $ip = $_GET['ip'];
        $ip_master = $_GET['ip_master'];

        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);

        if($database->affectedRows() == 1){
            //$query = "SELECT master_ip FROM vm WHERE vm = '$vm'";
            echo "<br/>Logged in as: $username <br/>";

            echo "<br/><b>Step 3 of 3</b> <br/>";


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
                             if (!($stream = ssh2_exec($con, "virt-install --connect qemu:///system -n $vm -r $ram --vcpus=$cpu --disk path=/var/lib/libvirt/images/$vm.img,size=$hdd --import --vnc --noautoconsole --os-type linux --accelerate --network=bridge:br0 --hvm > /home/$ssh_login/public_html/info/create_vm.$vm.txt" ))) {
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




				$query = sprintf("INSERT INTO user_vm (username, vm) VALUES ('$login', '$vm')");
				$affectedRows = $database->doQuery($query);

			    $query2 = sprintf("INSERT INTO vm (vm, ram, cpu, hdd, ip, master_ip, os) VALUES ('$vm', '$ram', '$cpu', '$hdd', '$ip', '$ip_master', '$os')");
				$affectedRows = $database->doQuery($query2);

			    $query3 = sprintf("DELETE FROM orders WHERE username = '$login'");
				$database->doQuery($query3);

				//echo "$os_dir /var/lib/libvirt/images/$vm.img | virt-install --connect qemu:///system -n $vm -r $ram --vcpus=$cpu --disk path=/var/lib/libvirt/images/$vm.img,size=$hdd --import --vnc --noautoconsole --os-type linux --accelerate --network=bridge:br0 --hvm > /home/$ssh_login/public_html/info/create_vm.$vm.txt <br/>";

			    echo "If there are no errors shown, the installation is complete. <br/>";
				$file = fopen("/home/$ssh_login/public_html/info/create_vm.$vm.txt", "r") or exit("Unable to open file!");
				//Output a line of the file until the end is reached
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