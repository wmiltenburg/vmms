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
    require_once 'include/classes/database.class.php';
?>
	<div id="body">
<?php

    $database = new Database();
    $database->openConnection();

    //Check if the username matches with the session
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['package']) && isset($_POST['name']) && isset($_POST['hdd']) && isset($_POST['ram']) && isset($_POST['cpu']) && isset($_POST['sla'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $package = $_GET['package'];
        $name = $_POST['name'];
        $hdd = $_POST['hdd'];
        $ram = $_POST['ram'];
        $cpu = $_POST['cpu'];
        $sla = $_POST['sla'];

        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);

        if($database->affectedRows() == 1){
            echo "Logged in as: $username <br/>";

            $query = "UPDATE vm_package SET name = '$name', hdd = '$hdd', ram = '$ram', cpu = '$cpu', sla = '$sla' WHERE name = '$package'";
            $database->doQuery($query);


            echo "Package: $package is updated:<br />";
            echo "Name: $name<br />";
            echo "HDD: $hdd<br />";
            echo "RAM: $ram<br />";
            echo "CPU: $cpu<br />";
            echo "SLA: $sla<br />";
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
            echo "Username or password is incorrect. Or the session has expired.";
        }

    } else {
        echo "You didn't fill in the form.";
    }
    $database->closeConnection();
?>
    </body>
</html>