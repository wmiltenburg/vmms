
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

    //Kijken of $username en $session wel bestaan
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['user'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $name = $_GET['user'];

        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);

        if($database->affectedRows() == 1){


            $query = "SELECT name FROM vm_package WHERE name = '$name'";

            $database->getQuery($query);
            if($database->affectedRows() == 1){

                $query2 = "SELECT * FROM vm_package WHERE name = '$name'";
                $info = $database->getQuery($query2);
                $name_package = $info['name'];
                $hdd = $info['hdd'];
                $ram = $info['ram'];
				$cpu = $info['cpu'];
                $cpu = $info['cpu'];
                $sla = $info['sla'];



                echo "<br/>Logged in as: $username <br/>";
                echo "<form method=\"post\" action=\"package_edit.php?username=$username&session=$session&package=$name\">";
                ?>
        <table>
            <tr>
                <th colspan="2">Change the packages, named: <?php echo $name_package; ?>:</th>
            </tr>

				<tr>
				<td>Name: </td>
				<td><input type="text" name="name" <? echo "value=\"$name_package\"" ?> /></td>
				</tr>

				<tr>
				<td>RAM: </td>
				<td><input type="text" name="ram" <? echo "value=\"$ram\"" ?> /></td>
				</tr>

				<tr>
				<td>CPU: </td>
				<td><input type="text" name="cpu" <? echo "value=\"$cpu\"" ?> /></td>
				</tr>

				<tr>
				<td>HDD: </td>
				<td><input type="text" name="hdd" <? echo "value=\"$hdd\"" ?> /></td>
				</tr>

				<tr>
				<td>SLA: </td>
				<td><select name="sla">

					<?php
					$query = "SELECT sla FROM sla";
					$vms = $database->getQuery($query);
					if ($database->affectedRows() > 1) {
						foreach($vms as $key => $vm1) {
							$sla_type = $vm1['sla'];
							echo "<option value=\"$sla_type\">$sla_type</option>";
					}
					}elseif ($database->affectedRows() == 1) {
						$sla_type = $vms['sla'];
						echo "<option value=\"$sla_type\">$sla_type</option>";
					}

                ?>
                 </select></td>
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
                echo "VM doesn't exist";
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

