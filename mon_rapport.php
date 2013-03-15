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

			echo "
				<div class=\"monitormenu\">
					<ul>
						";

			$query = "SELECT username, rights FROM admin WHERE username = '$username' AND rights = 1";
            		$database->getQuery($query);
            		if($database->affectedRows() == 1){

			echo "

						<li><a href=\"./monitoringconfiguratie.php?username=$username&session=$session\">
    							<INPUT TYPE=\"button\" VALUE=\"Configuration\" Class=\"knop\">
						</a></li>
			";}

			echo "			<li><a href=\"./mon_tactical.php?username=$username&session=$session\">
   							 <INPUT TYPE=\"button\" VALUE=\"Overview\" Class=\"knop\">
						</a></li>

						<li><a href=\"./mon_hoststatus.php?username=$username&session=$session\">
    							<INPUT TYPE=\"button\" VALUE=\"Status Hosts\" Class=\"knop\">
						</a></li>

						<li><a href=\"./mon_problems.php?username=$username&session=$session\">
    							<INPUT TYPE=\"button\" VALUE=\"Problems\" Class=\"knop\">
						</a></li>

						<li><a href=\"./mon_rapport.php?username=$username&session=$session\">
    							<INPUT TYPE=\"button\" VALUE=\"Reports\" Class=\"knop\">
						</a></li>


					</ul>
				</div>
			";


//IFrame voor nagios

			   	echo " <br/><b>Trends: </b><br/><br/>
				<iframe name=frame 1 src=\"/nagios/cgi-bin/trends.cgi\" frameborder=\"1\" scrolling=\"auto\" width=\"970\" height=\"800\" >

				</iframe> <br />";

				echo "<br/><b> Availability report: </b><br/><br/>
				<iframe name=frame 2 src=\"/nagios/cgi-bin/avail.cgi\" frameborder=\"1\" scrolling=\"auto\" width=\"970\" height=\"800\" >

				</iframe> <br />";

				echo "<br/><b> Alert Histogram </b><br/><br/>
				<iframe name=frame 3 src=\"/nagios/cgi-bin/histogram.cgi\" frameborder=\"1\" scrolling=\"auto\" width=\"970\" height=\"800\" >

				</iframe> <br />";

				echo "<br/><b>Alert Summary: </b><br/><br/>
				<iframe name=frame 5 src=\"/nagios/cgi-bin/summary.cgi\" frameborder=\"1\" scrolling=\"auto\" width=\"970\" height=\"800\" >

				</iframe><br />";

				echo "<br/><b>Notificaties: </b><br/><br/>
				<iframe name=frame 6 src=\"/nagios/cgi-bin/notifications.cgi\" frameborder=\"1\" scrolling=\"auto\" width=\"970\" height=\"800\" >

				</iframe><br />";

				echo "<br/><b>Logbestand: </b><br/><br/>
				<iframe name=frame 7 src=\"/nagios/cgi-bin/showlog.cgi\" frameborder=\"1\" scrolling=\"auto\" width=\"970\" height=\"800\" >

				</iframe><br />";


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
