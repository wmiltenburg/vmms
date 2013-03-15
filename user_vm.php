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

<?php

    $database = new Database();
    $database->openConnection();


    //Check if the username matches with the session
    if(isset($_GET['username']) && isset($_GET['session'])){
    //Get the data from the GET method, check if everyhting is sended from the form
    $username = $_GET['username'];
    $session = $_GET['session'];

        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);

        if($database->affectedRows() == 1){



?>
<div id="body">
		<?php		echo "<br/>You are currently logged in as: $username <br/>";
                echo "<form method=\"post\" action=\"user_vm_add.php?username=$username&session=$session\">"; ?> <br/>

        <table>
				<tr>
                <th colspan="2">Connect a virtual machine with an user:</th>
				</tr>

				<tr>
				<td>Username: </td>
				<td><select name="login">
					<?php

					$query = "SELECT username FROM admin";
					$vms = $database->getQuery($query);
					if ($database->affectedRows() > 1) {
						foreach($vms as $key => $vm1) {
							$login = $vm1['username'];
							echo "<option value=\"$login\">$login</option>";
					}
					}elseif ($database->affectedRows() == 1) {
						$login = $vms['username'];
						echo "<option value=\"$login\">$login</option>";
					} else {
                                            echo "<option value=\"There are no users available\"></option>";
                                        }
					?>
                </select></td>
				</tr>

				<tr>
				<td>VM: </td>
				<td><select name="vm">

				<?php

					$query = "SELECT vm FROM vm";
					$vms = $database->getQuery($query);
					if ($database->affectedRows() > 1) {
						foreach($vms as $key => $vm1) {
							$vm = $vm1['vm'];
							echo "<option value=\"$vm\">$vm</option>";
					}
					}elseif ($database->affectedRows() == 1) {
						$vm = $vms['vm'];
						echo "<option value=\"$vm\">$vm</option>";
					} else {
                                            echo "<option value=\"There are no VMs available\"></option>";
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



	<br />
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



	</div>
    </body>
</html>