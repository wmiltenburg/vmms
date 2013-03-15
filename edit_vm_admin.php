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
    if(isset($_GET['username']) && isset($_GET['session'])){

        $username = $_GET['username'];
        $session = $_GET['session'];

        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);

        if($database->affectedRows() == 1){

            echo "<br />These are all the orders:<br />";
			echo "<table id=\"customers\">";

            $query = "SELECT * FROM user_vm_edit, admin WHERE user_vm_edit.username = admin.username";
            $vms = $database->getQuery($query);
            if($database->affectedRows() > 1) {
                //Ech the users and give some options to change the users.
                echo "<tr>";
                echo "<th>Old Vm Name</th>";
                echo "<th>New Vm Name</th>";
                echo "<th>Username</th>";
                echo "<th>RAM</th>";
                echo "<th>CPU</th>";
                echo "<th>HDD</th>";
                echo "<th>Ip</th>";
                echo "<th>Master ip</th>";
                echo "<th>OS</th>";
                echo "<th>SLA</th>";
                echo "<th>Change</th>";
                echo "<th>Delete</th>";
                echo  "<th>User info</th>";
                echo  "<th>Difference</th>";
                echo "</tr> <br />";
                foreach($vms as $key => $vm1){
                    $vm_old = $vm1['vm'];
                   // $vm_new = $vm1['vm_name'];
                    $login = $vm1['username'];
                    $ram = $vm1['ram'];
                    $hdd = $vm1['hdd'];
					$cpu = $vm1['cpu'];
                    $ip = $vm1['ip'];
                    $master_ip = $vm1['master_ip'];
                    $os = $vm1['os'];
                    $sla = $vm1['sla'];

                    echo "<tr class='alt'>";
                    echo "<td>$vm_old</td>";
                    //echo "<td>$vm_new</td>";
                    echo "<td>$login</td>";
                    echo "<td>$ram</td>";
                    echo "<td>$hdd</td>";
                    echo "<td>$cpu</td>";
                    echo "<td>$ip</td>";
                    echo "<td>$master_ip</td>";
                    echo "<td>$os</td>";
                    echo "<td>$sla</td>";
                    echo "<td><a href=\"edit_vm_explain.php?username=$username&session=$session&vm_old=$vm_old&login=$login&ram=$ram&cpu=$cpu&hdd=$hdd&ip=$ip&master_ip=$master_ip&os=$os \"><img src=\"images/edit.png\" alt=\"Edit\" /></a></td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$login&command=vm_edit_delete\"><img src=\"images/del.png\" alt=\"Delete\" /></a></td>";
                    echo "<td><a href=\"user_info.php?username=$username&session=$session&login=$login\"><INPUT TYPE=\"button\" VALUE=\"User info\" Class=\"knop\"></a></td>";
                    echo "<td><a href=\"change_difference.php?username=$username&session=$session&user=$vm_old\"><INPUT TYPE=\"button\" VALUE=\"Difference\" Class=\"knop\"></a></td>";
                    echo "</tr>";
                }
            }
            elseif($database->affectedRows() == 1) {
                //Ech the users and give some options to change the users.

                echo "<tr>";
                echo "<th>Old Vm Name</th>";
                echo "<th>New Vm Name</th>";
                echo "<th>Username</th>";
                echo "<th>Ram</th>";
                echo "<th>HDD</th>";
                echo "<th>Ip</th>";
                echo "<th>Master ip</th>";
                echo "<th>OS</th>";
                echo "<th>SLA</th>";
                echo "<th>Change</th>";
                echo "<th>Delete</th>";
                echo  "<th>User info</th>";
                echo  "<th>Difference</th>";
                echo "</tr> <br />";

                    $vm_old = $vms['vm'];
                    $vm_new = $vms['vm_name'];
                    $login = $vms['username'];
                    $ram = $vms['ram'];
                    $cpu = $vms['cpu'];
                    $hdd = $vms['hdd'];
                    $ip = $vms['ip'];
                    $master_ip = $vms['master_ip'];
                    $os = $vms['os'];
                    $sla = $vms['sla'];

                    echo "<tr class='alt'>";
                    echo "<td>$vm_old</td>";
                    echo "<td>$vm_new</td>";
                    echo "<td>$login</td>";
                    echo "<td>$ram</td>";
                    echo "<td>$hdd</td>";
                    echo "<td>$ip</td>";
                    echo "<td>$master_ip</td>";
                    echo "<td>$os</td>";
                    echo "<td>$sla</td>";
                    echo "<td><a href=\"edit_vm_explain.php?username=$username&session=$session&vm_old=$vm_old&vm_new=$vm_new&login=$login&ram=$ram&cpu=$cpu&hdd=$hdd&ip=$ip&master_ip=$master_ip&os=$os&sla=$sla\"><img src=\"images/edit.png\" alt=\"Edit\" /></a></td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$login&command=vm_edit_delete\"><img src=\"images/del.png\" alt=\"Delete\" /></a></td>";
                    echo "<td><a href=\"user_info.php?username=$username&session=$session&login=$login\"><INPUT TYPE=\"button\" VALUE=\"User info\" Class=\"knop\"></a></td>";
                    echo "<td><a href=\"change_difference.php?username=$username&session=$session&user=$vm_old\"><INPUT TYPE=\"button\" VALUE=\"Difference\" Class=\"knop\"></a></td>";
                    echo "</tr>";
            } else {
                echo "<tr><td>There are no changes available!</td></tr>";
            }
                        echo "</table>";
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