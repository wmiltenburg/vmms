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
   	<div id="body">
<?php

    $database = new Database();
    $database->openConnection();

    //Kijken of $username en $session wel bestaan
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['user'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $vm = $_GET['user'];

        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);

        if($database->affectedRows() == 1){

            echo "<br />These are all the orders:<br />";
			echo "<table id=\"customers\">";

            $query = "SELECT * FROM vm, admin, user_vm WHERE vm.vm = '$vm' AND user_vm.vm = vm.vm AND admin.username = user_vm.username";
            $vms = $database->getQuery($query);

                //Ech the users and give some options to change the users.


                echo "<tr>";
                echo "<th>VM old name</th>";
                echo "<th>Username</th>";
                echo "<th>Ram</th>";
                echo "<th>CPU</th>";
                echo "<th>HDD</th>";
                echo "<th>Ip</th>";
                echo "<th>Master ip</th>";
                echo "<th>OS</th>";
                echo "<th>SLA</th>";
                echo "</tr> <br />";

                    $vm = $vms['vm'];
                    $login = $vms['username'];
                    $ram = $vms['ram'];
                    $cpu = $vms['cpu'];
                    $hdd = $vms['hdd'];
                    $ip = $vms['ip'];
                    $master_ip = $vms['master_ip'];
                    $os = $vms['os'];
                    $sla = $vms['sla'];



                    echo "<tr class='alt'>";
                    echo "<td>$vm</td>";
                    echo "<td>$login</td>";
                    echo "<td>$ram</td>";
                    echo "<td>$cpu</td>";
                    echo "<td>$hdd</td>";
                    echo "<td>$ip</td>";
                    echo "<td>$master_ip</td>";
                    echo "<td>$os</td>";
                    echo "<td>$sla</td>";
                    echo "</tr>";

                    $query2 = "SELECT * FROM admin, user_vm_edit WHERE user_vm_edit.vm = '$vm'AND admin.username = user_vm_edit.username";
            $vms = $database->getQuery($query2);

                //Ech the users and give some options to change the users.

            echo "<br/>";

                echo "<tr>";
                echo "<th>VM name</th>";
                echo "<th>Username</th>";
                echo "<th>Ram</th>";
                echo "<th>CPU</th>";
                echo "<th>HDD</th>";
                echo "<th>Ip</th>";
                echo "<th>Master ip</th>";
                echo "<th>OS</th>";
                echo "</tr> <br />";

                    $vm = $vms['vm'];
                    $login = $vms['username'];
                    $ram = $vms['ram'];
                    $cpu = $vms['cpu'];
                    $hdd = $vms['hdd'];
                    $ip = $vms['ip'];
                    $master_ip = $vms['master_ip'];
                    $os = $vms['os'];
                    //$sla = $vms['sla'];



                    echo "<tr class='alt'>";
                    echo "<td>$vm</td>";
                    echo "<td>$login</td>";
                    echo "<td>$ram</td>";
                    echo "<td>$cpu</td>";
                    echo "<td>$hdd</td>";
                    echo "<td>$ip</td>";
                    echo "<td>$master_ip</td>";
                    echo "<td>$os</td>";
                    echo "</tr>";



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
    $database->closeConnection();
?>

		</div>
    </body>
</html>