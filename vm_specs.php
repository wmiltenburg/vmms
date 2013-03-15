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
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['vm']) && isset($_GET['login']) && isset($_GET['login']) && isset($_GET['ram']) && isset($_GET['cpu']) && isset($_GET['hdd']) && isset($_GET['os'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $vm = $_GET['vm'];
        $login = $_GET['login'];
        $ram = $_GET['ram'];
		$cpu = $_GET['cpu'];
        $hdd = $_GET['hdd'];
        $os = $_GET['os'];
        //$sla = $_GET['sla'];


        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);

        if($database->affectedRows() == 1){
            echo "<br/>Logged in as: $username <br/>";

            echo "<b><br/>Step 1 of 3</b> <br/>";

echo "<form method=\"post\" action=\"vm_image_copy.php?username=$username&session=$session&login=$login\">";
                ?>
        <table>
            <tr>
                <th colspan="2"><br/>Connect a virtual machine with an user</th>
            </tr>

				<tr>
				<td>VM Name:</td>
				<td><input type="text" name="vm" <? echo "value=\"$vm\"" ?> /></td>
				</tr>

				<tr>
				<td>RAM:</td>
				<td><input type="text" name="ram" <? echo "value=\"$ram\"" ?> /></td>
				</tr>

				<tr>
				<td>CPU:</td>
				<td><input type="text" name="cpu" <? echo "value=\"$cpu\"" ?> /></td>
				</tr>

				<tr>
				<td>HDD: </td>
				<td><input type="text" name="hdd" <? echo "value=\"$hdd\"" ?></td>
				</tr>

				<tr>
				<td>OS: </td>
				<td><input type="text" name="os" <? echo "value=\"$os\"" ?></td>
				</tr>

				<tr>
				<td>IP (vm): </td>
				<td><input type="text" name="ip"></td>
				</tr>

				<tr>
				<td>IP (master): </td>
				<td><input type="text" name="ip_master"></td>
				</tr>

				<tr>
				<td colspan="2">
				<b><br/>Warning: Next step can take a while.</b><br />
				</td>
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


            </tr>
        </table>
        </form>
<?
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