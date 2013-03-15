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
        $os = $_GET['user'];

        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);

        if($database->affectedRows() == 1){


            $query = "SELECT os FROM os_dir WHERE os = '$os'";

            $database->getQuery($query);
            if($database->affectedRows() == 1){

                $query2 = "SELECT * FROM os_dir WHERE os = '$os'";
                $info = $database->getQuery($query2);
                $os = $info['os'];
                $path = $info['path'];



                echo "<br/>Logged in as: $username <br/>";
                echo "<form method=\"post\" action=\"os_edit.php?username=$username&session=$session&os=$os\">";
                ?>
        <table>
            <tr>
                <th colspan="2">Connect a virtual machine with an user</th>
            </tr>
			<tr>
                <td><br /><center><div id="os">OS: <input type="text" name="os" /><br /></div></center>
                <center><div id="path">   Path: <input type="text" name="path" /><br /></div></center>
                     <center> <div id="knopjes">
					<input type="submit" value="Submit" class='knop'>
					<input type="reset" value="Reset" class='knop'></center>
					</div><br />
                </td>
            </tr>
            <tr>
                <td colspan="2">
<?php
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
?>
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
