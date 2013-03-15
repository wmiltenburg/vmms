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
    if(isset($_GET['username']) && isset($_GET['session'])){

        $username = $_GET['username'];
        $session = $_GET['session'];

        //Check if username and password matches
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);
        if($database->affectedRows() == 1){

            echo "<br/>Logged in as: $username <br/>";

            echo "<br />This is a list with your available virtual machines:<br />";

           echo "<table id=\"customers\">";

            $query = "SELECT * FROM user_vm, vm, admin WHERE user_vm.username = '$username' AND admin.username = '$username' AND user_vm.vm = vm.vm";
            $vms = $database->getQuery($query);
            if ($database->affectedRows() > 1) {
                //Echo the virtual machine that is assigned to an user. And give the user some options
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>SLA</th>";
                echo "<th>Start</th>";
                echo  "<th>Stop</th>";
                echo  "<th>Destroy</th>";
                echo  "<th>Suspend</th>";
                echo  "<th>Resume</th>";
                echo  "<th>Specs</th>";
                echo  "<th>Info</th>";
                echo  "<th>Edit</th>";
                echo "</tr> <br />";
                foreach($vms as $key => $vm1) {
                    $vm = $vm1['vm'];
                    $sla = $vm1['sla'];
                    //$ip = $row['ip'];

                    echo "<tr class='alt'>";
                    echo "<td>$vm</td>";
                    echo "<td>$sla</td>";
                    echo "<td><a href=\"ssh.php?username=$username&session=$session&vm=$vm&command=start\"><INPUT TYPE=\"button\" VALUE=\"Start\" Class=\"knop\"></a></td>";
                    echo "<td><a href=\"ssh.php?username=$username&session=$session&vm=$vm&command=shutdown\"><INPUT TYPE=\"button\" VALUE=\"Shutdown\" Class=\"knop\"></a></td>";
                    echo "<td><a href=\"ssh.php?username=$username&session=$session&vm=$vm&command=destroy\"><INPUT TYPE=\"button\" VALUE=\"Destroy\" Class=\"knop\"></a></td>";
                    echo "<td><a href=\"ssh.php?username=$username&session=$session&vm=$vm&command=suspend\"><INPUT TYPE=\"button\" VALUE=\"Suspend\" Class=\"knop\"></a></td>";
                    echo "<td><a href=\"ssh.php?username=$username&session=$session&vm=$vm&command=resume\"><INPUT TYPE=\"button\" VALUE=\"Resume\" Class=\"knop\"></a></td>";
                    echo "<td><a href=\"specs.php?username=$username&session=$session&vm=$vm\"><INPUT TYPE=\"button\" VALUE=\"Specs\" Class=\"knop\"></a></td>";
                    echo "<td><a href=\"ssh.php?username=$username&session=$session&vm=$vm&command=dominfo\"><INPUT TYPE=\"button\" VALUE=\"Info\" Class=\"knop\"></a></td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$vm&command=vm_user_edit\"><INPUT TYPE=\"button\" VALUE=\"Edit\" Class=\"knop\"></a></td>";
                    echo "</tr>";
                }

                echo "<br />";
                echo "</table> <br />";


                

            }
            elseif ($database->affectedRows() == 1) {
                                //Echo the virtual machine that is assigned to an user. And give the user some options
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>SLA</th>";
                echo "<th>Start</th>";
                echo  "<th>Stop</th>";
                echo  "<th>Destroy</th>";
                echo  "<th>Suspend</th>";
                echo  "<th>Resume</th>";
                echo  "<th>Specs</th>";
                echo  "<th>Info</th>";
                echo  "<th>Edit</th>";
                echo "</tr> <br />";

                $vm = $vms['vm'];
                $sla = $vms['sla'];
                //$ip = $row['ip'];

                echo "<tr class='alt'>";
                echo "<td>$vm</td>";
                echo "<td>$sla</td>";
                    echo "<td><a href=\"ssh.php?username=$username&session=$session&vm=$vm&command=start\"><INPUT TYPE=\"button\" VALUE=\"Start\" Class=\"knop\"></a></td>";
                    echo "<td><a href=\"ssh.php?username=$username&session=$session&vm=$vm&command=shutdown\"><INPUT TYPE=\"button\" VALUE=\"Shutdown\" Class=\"knop\"></a></td>";
                    echo "<td><a href=\"ssh.php?username=$username&session=$session&vm=$vm&command=destroy\"><INPUT TYPE=\"button\" VALUE=\"Destroy\" Class=\"knop\"></a></td>";
                    echo "<td><a href=\"ssh.php?username=$username&session=$session&vm=$vm&command=suspend\"><INPUT TYPE=\"button\" VALUE=\"Suspend\" Class=\"knop\"></a></td>";
                    echo "<td><a href=\"ssh.php?username=$username&session=$session&vm=$vm&command=resume\"><INPUT TYPE=\"button\" VALUE=\"Resume\" Class=\"knop\"></a></td>";
                    echo "<td><a href=\"specs.php?username=$username&session=$session&vm=$vm\"><INPUT TYPE=\"button\" VALUE=\"Specs\" Class=\"knop\"></a></td>";
                    echo "<td><a href=\"ssh.php?username=$username&session=$session&vm=$vm&command=dominfo\"><INPUT TYPE=\"button\" VALUE=\"Info\" Class=\"knop\"></a></td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$vm&command=vm_user_edit\"><INPUT TYPE=\"button\" VALUE=\"Edit\" Class=\"knop\"></a></td>";
                echo "</tr>";

                echo "<br />";
           } else {
                echo "<tr>
                        <th>There are no Virtual Machines registered!</th>
                        </tr>";
            }                
                echo "</table> <br />";

				echo "<br /><div id=\"dashboard\">
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