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
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['vm']) && isset($_GET['hdd']) && isset($_GET['ram']) && isset($_GET['os'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $vm = $_GET['vm'];
        $hdd = $_GET['hdd'];
        $ram = $_GET['ram'];
        $os = $_GET['os'];

        //Check if username and password matches
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);
        if($database->affectedRows() == 1){
            
            echo "Logged in as: $username <br/>"; 
            
            echo "Select an SLA: <br/>";

            echo "These are all the SLA's:<br />";

            echo "<table id=\"customers\">";
            $query = "SELECT * FROM sla";
            $vms = $database->getQuery($query);
            if($database->affectedRows() > 1) {
                //Ech the users and give some options to change the users.
                echo "<tr>"; 
                echo "<th>SLA</th>";
                echo  "<th>choose SLA</th>";
                echo "</tr> <br />";     
                foreach($vms as $key => $vm1){           
                    $sla = $vm1['sla'];

                   



                    echo "<tr class='alt'>";
                    echo "<td>$sla</td>";         
                    echo "<td><a href=\"request.php?username=$username&session=$session&vm=$vm&hdd=$hdd&ram=$ram&os=$os&sla=$sla\"><INPUT TYPE=\"button\" VALUE=\"Create VM\" Class=\"knop\"></a></td>";
                    echo "</tr>";
                }

                
            }
            elseif($database->affectedRows() == 1) {
                //Ech the users and give some options to change the users.
                //Ech the users and give some options to change the users.
                echo "<tr>"; 
                echo "<th>SLA</th>";
                echo  "<th>Choose Sla</th>";
                echo "</tr> <br />";     
                          
                    $sla = $vms['sla'];

                   



                    echo "<tr class='alt'>";
                    echo "<td>$sla</td>";         
                    echo "<td><a href=\"request.php?username=$username&session=$session&vm=$vm&hdd=$hdd&ram=$ram&os=$os&sla=$sla\"><INPUT TYPE=\"button\" VALUE=\"Create VM\" Class=\"knop\"></a></td>";
                    echo "</tr>";

                          
            }
            echo "<br />";
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