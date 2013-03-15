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
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['user'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $package = $_GET['user'];

        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);

        if($database->affectedRows() == 1){
            echo "<br/>Logged in as: $username <br/>";


            $query = "SELECT name FROM vm_package WHERE name = '$package'";

            $database->getQuery($query);

            if($database->affectedRows() == 1){

                echo "<br/>Package exists and trying to delete it from the database <br />";

            $query = sprintf("DELETE FROM vm_package WHERE name = '$package'");
            $database->doQuery($query);

            echo "<br/>Package $package is deleted from the database <br/><br/>";


           	echo "<table id=\"options1\"><td>Go back to your dashboard: </td>
				<td>
					<div id=\"optionslink\">
						<a href=\"./poptions.php?username=$username&session=$session\">
							<INPUT TYPE=\"button\" VALUE=\"Click here\" Class=\"knop\">
						</a>
					</div>
				</td>
				</table>";

			   echo "<br />";

                echo "<table id=\"options1\"><td>Logout: </td>
				<td>
					<div id=\"optionslink\">
						<a href=\"./logout.php?username=$username&session=$session\">
							<INPUT TYPE=\"button\" VALUE=\"Click here\" Class=\"knop\">
						</a>
					</div>
				</td>
				</table><br />";
            } else {
                echo "Package $package doesn't exist";
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
