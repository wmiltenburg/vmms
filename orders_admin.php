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

            echo "<br />These are all the orders:";
            echo "<table id=\"customers\">";

            $query = "SELECT * FROM orders, admin WHERE orders.username = admin.username";
            $vms = $database->getQuery($query);
            if($database->affectedRows() > 1) {
                //Ech the users and give some options to change the users.
                echo "<tr>";
                echo "<th>Vm</th>";
                echo "<th>Username</th>";
                echo  "<th>RAM</th>";
                echo  "<th>CPU</th>";
                echo  "<th>HDD</th>";
                echo  "<th>OS</th>";
                echo  "<th>SLA</th>";
                echo  "<th>Create</th>";
                echo  "<th>Delete</th>";
                echo  "<th>User info</th>";
                echo "</tr> <br />";
                foreach($vms as $key => $vm1){
                    $vm = $vm1['vm'];
                    $login = $vm1['username'];
                    $ram = $vm1['ram'];
                    $cpu = $vm1['cpu'];
                    $hdd = $vm1['hdd'];
                    $os = $vm1['os'];
                    $sla = $vm1['sla'];

                    echo "<tr class='alt'>";
                    echo "<td>$vm</td>";
                    echo "<td>$login</td>";
                    echo "<td>$ram</td>";
                    echo "<td>$cpu</td>";
                    echo "<td>$hdd</td>";
                    echo "<td>$os</td>";
                    echo "<td>$sla</td>";
                    echo "<td><a href=\"vm_specs.php?username=$username&session=$session&vm=$vm&login=$login&ram=$ram&cpu=$cpu&hdd=$hdd&os=$os&sla=$sla\"><img src=\"images/add.png\" alt=\"Create\" /></a></td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$login&command=order_delete\"><img src=\"images/del.png\" alt=\"Delete\" /></a></td>";
                    echo "<td><a href=\"user_info.php?username=$username&session=$session&login=$login\"><img src=\"images/info.png\" alt=\"Info\" /></a></td>";
                    echo "</tr>";
                }
            }
            elseif($database->affectedRows() == 1) {
                //Ech the users and give some options to change the users.
                echo "<tr>";
                echo "<th>Vm</th>";
                echo "<th>Username</th>";
                echo  "<th>RAM</th>";
                echo  "<th>CPU</th>";
                echo  "<th>HDD</th>";
                echo  "<th>OS</th>";
                echo  "<th>SLA</th>";
                echo  "<th>Create</th>";
                echo  "<th>Delete</th>";
                echo  "<th>User info</th>";
                echo "</tr> <br />";

                $vm = $vms['vm'];
                $login = $vms['username'];
                $ram = $vms['ram'];
                $cpu = $vms['cpu'];
                $hdd = $vms['hdd'];
                $os = $vms  ['os'];
                $sla = $vms  ['sla'];

                echo "<tr class='alt'>";
                echo "<td>$vm</td>";
                echo "<td>$login</td>";
                echo "<td>$ram</td>";
                echo "<td>$cpu</td>";
                echo "<td>$hdd</td>";
                echo "<td>$os</td>";
                echo "<td>$sla</td>";
                echo "<td><a href=\"vm_specs.php?username=$username&session=$session&vm=$vm&login=$login&ram=$ram&cpu=$cpu&hdd=$hdd&os=$os&sla=$sla\"><img src=\images/add.png\" alt=\"Create\" /></a></td>";
                echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$login&command=order_delete\"><img src=\"images/del.png\" alt=\"Delete\" /></a></td>";
                echo "<td><a href=\"user_info.php?username=$username&session=$session&login=$login\"><img src=\"images/info.png\" alt=\"Info\" /></a></td>";
                echo "</tr>";
            } else {
                echo "<tr><td>There are no orders available!</td></tr>";
            }
            echo "<br />";
                echo "<br />";
                echo "</table> <br />";


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

    </body>
</html>