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
    if(isset($_GET['username']) && isset($_GET['session'])){

        $username = $_GET['username'];
        $session = $_GET['session'];

        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);

        if($database->affectedRows() == 1){

            echo "<br/>These are all the orders:";

             echo "<table id=\"customers\">";

            $query = "SELECT * FROM vm_package";
            $vms = $database->getQuery($query);
            if($database->affectedRows() > 1) {
                //Ech the users and give some options to change the users.
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>HDD</th>";
                echo "<th>Ram</th>";
				echo "<th>CPU</th>";
                echo "<th>SLA</th>";
                echo  "<th>Change</th>";
                echo  "<th>Delete</th>";

                echo "</tr> <br />";
                foreach($vms as $key => $vm1){
                    $name = $vm1['name'];
                    $hdd = $vm1['hdd'];
                    $ram = $vm1['ram'];
					$cpu = $vm1['cpu'];
                    $sla = $vm1['sla'];

                    echo "<tr class='alt'>";
                    echo "<td>$name</td>";
                    echo "<td>$hdd</td>";
                    echo "<td>$ram</td>";
                    echo "<td>$cpu</td>";
                    echo "<td>$sla</td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$name&command=package_change\"><img src=\"images/edit.png\" alt=\"Edit\" /></a></td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$name&command=package_delete\"><img src=\"images/del.png\" alt=\"Delete\" /></a></td>";
                    echo "</tr>";
                }
            }
            elseif($database->affectedRows() == 1) {
                //Ech the users and give some options to change the users.
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>HDD</th>";
                echo "<th>RAM</th>";
				echo "<th>CPU</th>";
                echo "<th>SLA</th>";
                echo  "<th>Change</th>";
                echo  "<th>Delete</th>";

                echo "</tr> <br />";

                    $name = $vms['name'];
                    $hdd = $vms['hdd'];
                    $ram = $vms['ram'];
                    $cpu = $vms['cpu'];
                    $sla = $vms['sla'];

                    echo "<tr class='alt'>";
                    echo "<td>$name</td>";
                    echo "<td>$hdd</td>";
                    echo "<td>$ram</td>";
                    echo "<td>$cpu</td>";
                    echo "<td>$sla</td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$name&command=package_change\"><img src=\"images/edit.png\" alt=\"Edit\" /></a></td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$name&command=package_delete\"><img src=\"images/del.png\" alt=\"Delete\" /></a></td>";
                    echo "</tr>";
            } else {
                echo "<tr><td>There are no packages available!</td></tr>";
            }
            echo "<br />";
                echo "<br />";
                echo "</table> <br />";


    echo "<form method=\"post\" action=\"./package_add.php?username=$username&session=$session\">";
                ?>
        <table>
				<tr>
				<th colspan="2">Add package:</th>
				</tr>

				<tr>
				<td>Name: </td>
				<td><input type="text" name="name" /></td>
				</tr>

				<tr>
				<td>RAM: </td>
				<td><input type="text" name="ram" /></td>
				</tr>

				<tr>
				<td>HDD: </td>
				<td><input type="text" name="hdd" /></td>
				</tr>

				<tr>
				<td>CPU(1,2,3,4): </td>
				<td><select name="cpu">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                </td>
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
		<br/>
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

                    </td>
            </tr>
        </table>
        </form>
    </body>
</html>