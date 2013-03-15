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
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_POST['login']) && isset($_POST['vm'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $login = $_POST['login'];
        $vm = $_POST['vm'];

        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);
        
        if($database->affectedRows() == 1){

            echo "Logged in as: $username <br/>";
            $query2 = "SELECT vm FROM vm WHERE vm = '$vm'";
            $database->getQuery($query2);
            if($database->affectedRows()==1){

                $query = sprintf("INSERT INTO user_vm (username, vm) VALUES ('$login', '$vm')");
                $database->doQuery($query);

                echo "Virtual machine: $vm is assigned to $login<br />";

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
                echo "VM is not added.";
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