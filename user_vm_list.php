<?
/**
 * @author Wouter Miltenburg
 * @version 1.0
  */
?>
<?php
    require_once 'include/classes/database.class.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php include 'include/title.php'; ?></title>
        <link rel="stylesheet" href="./css/plaintech.css" type="text/css" />
    </head>
    <body>
<?php
    include 'include/header.php';
?>
	<div id="body">
<?php
    $database = new Database();
    $database->openConnection();

    //Check if everything is filled in correctly
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['user'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $user = $_GET['user'];

        //Check if username and password matches
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);
        if($database->affectedRows() == 1){

            echo "<br/>Logged in as: $username <br/>";

            echo "<br />This is a list with your available virtual machines:<br />";

           echo "<table id=\"customers\">";

            $query = "SELECT * FROM user_vm, vm WHERE user_vm.username = '$user' AND user_vm.vm = vm.vm";
            $vms = $database->getQuery($query);
            if ($database->affectedRows() > 1) {
                //Echo the virtual machine that is assigned to an user. And give the user some options
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>SLA</th>";
                echo "<th>RAM</th>";
                echo  "<th>HDD</th>";
                echo  "<th>IP</th>";
                echo  "<th>Master IP</th>";
                echo  "<th>OS</th>";
                echo "</tr> <br />";
                foreach($vms as $key => $vm1) {
                    $vm = $vm1['vm'];
                    $sla = $vm1['sla'];
                    $ram = $vm1['ram'];
                    $hdd = $vm1['hdd'];
                    $ip = $vm1['ip'];
                    $master_ip = $vm1['master_ip'];
                    $os = $vm1['os'];

                    echo "<tr class='alt'>";
                    echo "<td>$vm</td>";
                    echo "<td>$sla</td>";
                    echo "<td>$ram</td>";
                    echo "<td>$hdd</td>";
                    echo "<td>$ip</td>";
                    echo "<td>$master_ip</td>";
                    echo "<td>$os</td>";
                    echo "</tr>";
                }

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

            }
            elseif ($database->affectedRows() == 1) {
                                //Echo the virtual machine that is assigned to an user. And give the user some options
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>SLA</th>";
                echo "<th>RAM</th>";
                echo  "<th>HDD</th>";
                echo  "<th>IP</th>";
                echo  "<th>Master IP</th>";
                echo  "<th>OS</th>";
                echo "</tr> <br />";

                    $vm = $vms['vm'];
                    $sla = $vms['sla'];
                    $ram = $vms['ram'];
                    $hdd = $vms['hdd'];
                    $ip = $vms['ip'];
                    $master_ip = $vms['master_ip'];
                    $os = $vms['os'];

                    echo "<tr class='alt'>";
                    echo "<td>$vm</td>";
                    echo "<td>$sla</td>";
                    echo "<td>$ram</td>";
                    echo "<td>$hdd</td>";
                    echo "<td>$ip</td>";
                    echo "<td>$master_ip</td>";
                    echo "<td>$os</td>";
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