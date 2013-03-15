<?
/**
 * @author Wouter Miltenburg
 * @version 1.0
  */
?>
<?php
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

    //Check if everything is filled in correctly
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['vm'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $vm = $_GET['vm'];

        //Check if username and password matches
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);
        if($database->affectedRows() == 1){

            echo "<br/>Logged in as: $username <br/>";

            echo "<br />Here is a list with the users that are assigned to $vm:<br />";

           echo "<table id=\"customers\">";

            $query = "SELECT * FROM user_vm, vm, admin WHERE user_vm.vm = '$vm' AND user_vm.username = admin.username GROUP BY user_vm.username";
            $vms = $database->getQuery($query);
            if ($database->affectedRows() > 1) {
                //Echo the virtual machine that is assigned to an user. And give the user some options
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>SLA</th>";
                echo "<th>Delete</th>";

                echo "</tr> <br />";
                foreach($vms as $key => $vm1) {
                    $login = $vm1['username'];
                    $sla = $vm1['sla'];
                    //$ip = $row['ip'];

                    echo "<tr class='alt'>";
                    echo "<td>$login</td>";
                    echo "<td>$sla</td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$login&vm=$vm&command=user_vm_delete\"><INPUT TYPE=\"button\" VALUE=\"Delete\" Class=\"knop\"></a></td>";
                    echo "</tr>";
                }

                echo "<br />";
                echo "</table> <br />";


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

            }
            elseif ($database->affectedRows() == 1) {
                                //Echo the virtual machine that is assigned to an user. And give the user some options
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>SLA</th>";
                echo "<th>Delete</th>";
                echo "</tr> <br />";

                $login = $vms['username'];
                $sla = $vms['sla'];
                //$ip = $row['ip'];

                echo "<tr class='alt'>";
                echo "<td>$login</td>";
                echo "<td>$sla</td>";
                echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$login&vm=$vm&command=user_vm_delete\"><INPUT TYPE=\"button\" VALUE=\"Delete\" Class=\"knop\"></a></td>";

                echo "</tr>";

                echo "<br />";
                echo "</table> <br />";

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