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
        <title><?php include 'include/title.php'; ?></title>
        <link rel="stylesheet" href="./css/plaintech.css" type="text/css" />
    </head>
    <body>
<?php
    include 'include/header.php';
    require_once('include/classes/database.class.php');
?>
   	<div id="body">
<?php

    $database = new Database();
    $database->openConnection();

    //Check if the username matches with the session
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['vm']) && isset($_GET['ram']) && isset($_GET['cpu']) && isset($_GET['hdd']) && isset($_GET['os'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $vm = $_GET['vm'];
        $ram = $_GET['ram'];
		$cpu = $_GET['cpu'];
        $hdd = $_GET['hdd'];
        $os = $_GET['os'];
        //$sla = $_GET['sla'];


        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);

        if($database->affectedRows() == 1){

            echo "<br/>Logged in as: $username <br/>";



            $query = "SELECT username FROM orders WHERE username = '$username'";
            $database->getQuery($query);

            if($database->affectedRows() !== 1){


                $query = sprintf("INSERT INTO orders (vm, username, ram, cpu, hdd, os) VALUES ('$vm', '$username', '$ram', '$cpu', '$hdd', '$os')");
                $affectedRows = $database->doQuery($query);


			echo"<table>
				<th colspan=\"2\"><br/>Virtual Machine $vm requested and will be up soon<br /></th>
				<tr><td>VM</td><td>$vm</td></tr>
				<tr><td>RAM</td><td>$ram</td></tr>
				<tr><td>CPU</td><td>$cpu</td></tr>
				<tr><td>HDD</td><td>$hdd</td></tr>
				<tr><td>OS</td><td>$os</td></tr>
				</table>";

            //echo "SLA: $sla<br />";
            echo "<br />";

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
            echo "You already placed an order. Wait until that one has been processed.";
        }

        }else{
            echo "Username or password is incorrect. Or the session has expired.";
        }

    }else{
        echo "You didn't fill in the form.";
    }
    $database->closeConnection();
?>
        		</div>
    </body>
</html>