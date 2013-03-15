<?
/**
 * @author Wouter Miltenburg
 * @version 1.0
  */
?>
<?php
    include 'include/ssh_logins.php';
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

    //Kijken of $username en $session wel bestaan
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['user']) && isset($_GET['command'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $user = $_GET['user'];
        $command = $_GET['command'];

        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);
        if($database->affectedRows() == 1){

            echo "<br/>Are you sure to $command the user $user? <br/><br/>";
            if(isset($_GET['vm'])){
                $vm = $_GET['vm'];
                echo "<a href=\"$command.php?username=$username&session=$session&user=$user&vm=$vm\"><INPUT TYPE=\"button\" VALUE=\"Yes\" Class=\"knop\"></a> ";

            }else{
            echo "<a href=\"$command.php?username=$username&session=$session&user=$user\"><INPUT TYPE=\"button\" VALUE=\"Yes\" Class=\"knop\"></a> ";
            }
            echo "<a href=\"poptions.php?username=$username&session=$session\"><INPUT TYPE=\"button\" VALUE=\"No\" Class=\"knop\"></a> <br/>

			";


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


        } else{
            echo "Username or password is incorrect. Or the session has expired.";
        }

    } else{
        echo "You didn't fill in the form.";
    }
    $database->closeConnection();
?>

  		</div>
    </body>
</html>