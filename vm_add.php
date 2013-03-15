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
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_POST['vm']) && isset($_POST['ram']) && isset($_POST['cpu']) && isset($_POST['hdd']) && isset($_POST['ip']) && isset($_POST['ip_master'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $vm = $_POST['vm'];
        $ram = $_POST['ram'];
		$cpu = $_POST['cpu'];
        $hdd = $_POST['hdd'];
        $ip = $_POST['ip'];
        $ip_master = $_POST['ip_master'];

        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);

        if($database->affectedRows() == 1){

            echo "<br/>Logged in as: $username <br/>";



            $query = "SELECT vm FROM vm WHERE vm = '$vm'";
            $database->getQuery($query);

            if($database->affectedRows() == 0){

             $query = sprintf("INSERT INTO vm (vm, ram, cpu, hdd, ip, master_ip) VALUES ('$vm', '$ram', '$cpu', '$hdd', '$ip', '$ip_master')");
            $database->doQuery($query);

			echo"<table>
				<th colspan=\"2\"><br/>Virtual Machine $vm is added with this specs:<br /></th>
				<tr><td>RAM</td><td>$ram</td></tr>
				<tr><td>CPU</td><td>$ram</td></tr>
				<tr><td>HDD</td><td>$hdd</td></tr>
				<tr><td>IP</td><td>$ip</td></tr>
				</table>";

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
            echo "VM is already added";
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