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

    //Check if everything is filled in correctly
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['vm'])){

    $username = $_GET['username'];
    $session = $_GET['session'];
    $vm = $_GET['vm'];

        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);

        if($database->affectedRows() == 1){


            echo "This is a list with your available virtual machines:<br />";

            echo "<table id=\"customers\">";

            $query = "SELECT * FROM vm WHERE vm = '$vm'";
            $vms = $database->getQuery($query);
            //Echo the virtual machine specs.
            echo "<tr>";
            echo "<th>Vm</th>";
            echo "<th>Ram</th>";
            echo "<th>CPU</th>";
            echo "<th>HDD</th>";
            echo "<th>IP</th>";
            echo "<th>Master IP</th>";
            echo "</tr> <br />";



                $name = $vms['vm'];
                $ram = $vms['ram'];
                $cpu = $vms['cpu'];
                $hdd = $vms['hdd'];
                $ip = $vms['ip'];
                $master_ip = $vms['master_ip'];

                echo "<tr class='alt'>";
                echo "<td>$name</td>";
                echo "<td>$ram</td>";
                echo "<td>$cpu</td>";
                echo "<td>$hdd</td>";
                echo "<td>$ip</td>";
                echo "<td>$master_ip</td>";
                echo "</tr>";





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
?>

       		</div>
    </body>
</html>