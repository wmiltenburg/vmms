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
        $vm = $_GET['user'];

        echo "Debug $vm <br/>";



        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);

        if($database->affectedRows() == 1){
            echo "<br />Logged in as: $username <br/>";
            $query2 = "SELECT * FROM vm WHERE vm = '$vm'";
            $info = $database->getQuery($query2);
            $vm_name = $info['vm'];
            $ram = $info['ram'];
            $cpu = $info['cpu'];
            //echo "Debug: $ram <br/>";
            $hdd = $info['hdd'];
            $ip = $info['ip'];
            $master_ip = $info['master_ip'];
            //$sla = $info['sla'];
            $os = $info['os'];


echo "<form method=\"post\" action=\"request_change.php?username=$username&session=$session&vm=$vm\">";
                ?>
        <table>
            <tr>
                <th colspan="2">Connect a virtual machine with an user</th>
            </tr>
<tr>
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
				<td><input type="text" name="ip" <? echo "value=\"$ip\"" ?>></td>
				</tr>

				<tr>
				<td>IP (master): </td>
				<td><input type="text" name="master_ip" <? echo "value=\"$master_ip\"" ?>></td>
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