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

    //Kijken of $username en $session wel bestaan
    if(isset($_GET['username']) && isset($_GET['session'])){

        $username = $_GET['username'];
        $session = $_GET['session'];

        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND password = '$session' AND rights = 1";
        $database->getQuery($query);

        if($database->affectedRows() == 0){

        echo "<br/>Logged in as: $username <br/>";
        echo "<form method=\"post\" action=\"vm_add.php?username=$username&session=$session\">";
?>

        <table>
            <tr>
                <th colspan="2"><br />Create a virtual machine:</th>
            </tr>

			<tr>
				<td>Virtual Machine:</td>
				<td><input type="text" name="vm" /></td>
				</tr>

				<tr>
				<td>RAM:</td>
				<td><input type="text" name="ram" /></td>
				</tr>

				<tr>
				<td>HDD: </td>
				<td><input type="text" name="hdd" /></td>
				</tr>
            
                                <tr>
				<td>CPU:</td>
				<td><input type="text" name="cpu" /></td>
				</tr>

				<tr>
				<td>IP (vm): </td>
				<td><input type="text" name="ip" /></td>
				</tr>

				<tr>
				<td>IP (master): </td>
				<td><input type="text" name="ip_master" /></td>
				</tr>

				
			                <tr>
				<td></td>
				<td>
				<br/>

					<input type="submit" value="Submit" class='knop'></a>
					<input type="reset" value="Reset" class='knop'></a>

                <br/>
				</td>
				</tr>



        </table>
        </form>

   <?php
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