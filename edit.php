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
        $user = $_GET['user'];

        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);

        if($database->affectedRows() == 1){


            $query = "SELECT username FROM admin WHERE username = '$user'";

            $database->getQuery($query);
            if($database->affectedRows() == 1){

                $query2 = "SELECT * FROM admin WHERE username = '$user'";
                $info = $database->getQuery($query2);
                $login = $info['username'];
                $name = $info['name'];
                $lname = $info['lname'];
                $mail = $info['mail'];
                $phone = $info['phone'];
                





                echo "<br/>Logged in as: $username <br/>";
                if ($_GET["msg"] == "error") {
                    echo "U heeft geen wachtwoord ingevuld!";
                }
                
                echo "<form method=\"post\" action=\"change.php?username=$username&session=$session&user=$user\">";
                ?>
        <table>
				<tr>
				<br /> <th colspan="2">Create an user:</th>
				</tr>
				<tr>
				<td>Username:</td>
				<td><input type="text" name="login" <? echo "value=\"$login\"" ?>/></td>
				</tr>

				<tr>
				<td>Password:</td>
				<td><input type="password" name="password" /></td>
				</tr>

				<tr>
				<td>Password (again): </td>
				<td><input type="password" name="password2" /></td>
				</tr>

				<tr>
				<td>Name: </td>
				<td><input type="text" name="name" <? echo "value=\"$name\"" ?>/></td>
				</tr>

				<tr>
				<td>Surname: </td>
				<td><input type="text" name="lname" <? echo "value=\"$lname\"" ?>/></td>
				</tr>

				<tr>
				<td>E-Mail: </td>
				<td><input type="text" name="mail" <? echo "value=\"$mail\"" ?>/></td>
				</tr>

				<tr>
				<td>Phone: </td>
				<td><input type="text" name="phone" <? echo "value=\"$phone\"" ?>/></td>
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
							}	elseif ($database->affectedRows() == 1) {
							$sla_type = $vms['sla'];
							echo "<option value=\"$sla_type\">$sla_type</option>";
							}


						?>
				</select></td>
				</tr>

				<tr>
				<td>Rights: </td>
				<td><select name="rights">
				<option value="0">User</option>
				<option value="1">Admin</option>
				</select></td>
				</tr>
				<tr>
				<td></td>
				<td>
				<br/>

					<input type="submit" value="Submit" class='knop'></a>
					<input type="reset" value="Reset" class='knop'></a>

                <br/><br/>
				</td>
				</tr>
			</table>
        </form>

<?php

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
                echo "User doesn't exist";
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
