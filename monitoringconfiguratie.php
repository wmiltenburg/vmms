<?
/**
 * @author Zacar Culhaci
 * @version 1.0
  */
?>
<?php
    //include 'include/connections.php';
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
    <br />
<?php
 //Check svn
    //Check if everything is filled in correctly
    $database = new Database();
    $database->openConnection();
    if(isset($_GET['username']) && isset($_GET['session'])){

        $username = $_GET['username'];
        $session = $_GET['session'];


//Check if the $username matches with the $session
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);
        if($database->affectedRows() == 1){

            echo "<br/>Logged in as: $username <br/><br/>";

			$query = "SELECT username, rights FROM admin WHERE username = '$username' AND rights = 1";
            		$database->getQuery($query);
            		if($database->affectedRows() == 1){


			echo "<table id=\"options3\"><tr>
				<td>
					<div id=\"optionslink\">
						<a href=\"./mon_tactical.php?username=$username&session=$session\">
							<INPUT TYPE=\"button\" VALUE=\"Back to Monitoring Tool\" Class=\"knop\">
						</a>
					</div>
				</td>
				<br />


				<td>
					<div id=\"optionslink\">
						<a href=\"include/scripts/script.nconf_update.php?username=$username&session=$session\">

							<INPUT TYPE=\"button\" VALUE=\"Update Nagios Configuration\" Class=\"knop\">
						</a>
					</div>
				</td></tr>
				</table><br />";


			}



//IFrame voor nconf

			   	echo " <iframe name=frame 1 src=\"/nconf\" frameborder=\"0\" scrolling=\"auto\" width=\"1000\" height=\"800\" >

				</iframe>";



				echo "</br></br></br></br><div id=\"dashboard\">
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
