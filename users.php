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

            echo "<br />These are all the users:";
            echo "<table id=\"customers\">";

            $query = "SELECT * FROM admin";
            $vms = $database->getQuery($query);
            if ($database->affectedRows() > 1) {
                //Ech the users and give some options to change the users.
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>Edit</th>";
                echo  "<th>Delete</th>";
                echo  "<th>Vm's</th>";
                echo  "<th>Info</th>";
                echo  "<th>Rights</th>";
                echo  "<th>SLA</th>";
                echo "</tr> <br />";
                foreach($vms as $key => $vm1){
                    $name = $vm1['username'];
                    $right = $vm1['rights'];
                    $sla = $vm1['sla'];

                    echo "<tr class='alt'>";
                    echo "<td>$name</td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$name&command=edit\"><img src=\"images/edit.png\" alt=\"Edit\" /></a></td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$name&command=delete\"><img src=\"images/del.png\" alt=\"Delete\" /></a></td>";
                    echo "<td><a href=\"user_vm_list.php?username=$username&session=$session&user=$name\"><img src=\"images/comp.png\" alt=\"VM\" /></a></td>";
                    echo "<td><a href=\"user_info.php?username=$username&session=$session&login=$name\"><img src=\"images/info.png\" alt=\"Info\" /></a></td>";
                    echo "<td>$right</td>";
                    echo "<td>$sla</td>";
                    echo "</tr>";
                }
            }

            elseif ($database->affectedRows() == 1) {
                //Ech the users and give some options to change the users.
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>Edit</th>";
                echo  "<th>Delete</th>";
                echo  "<th>Vm's</th>";
                echo  "<th>Info</th>";
                echo  "<th>Rights</th>";
                echo  "<th>SLA</th>";
                echo "</tr> <br />";

                $name = $vms['username'];
                $right = $vms['rights'];
                $sla = $vms['sla'];

                echo "<tr class='alt'>";
                    echo "<td>$name</td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$name&command=edit\"><img src=\"images/edit.png\" alt=\"Edit\" /></a></td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$name&command=delete\"><img src=\"images/del.png\" alt=\"Delete\" /></a></td>";
                    echo "<td><a href=\"user_vm_list.php?username=$username&session=$session&user=$name\"><img src=\"images/comp.png\" alt=\"VM\" /></a></td>";
                    echo "<td><a href=\"user_info.php?username=$username&session=$session&login=$name\"><img src=\images/info.png\" alt=\"Info\" /></a></td>";
                    echo "<td>$right</td>";
                    echo "<td>$sla</td>";
                    echo "</tr>";

                echo "<br />";
            } else {
                echo "<tr><td>There are no users in the database available!</td></tr>";
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