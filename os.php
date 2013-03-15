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
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['vm']) && isset($_GET['hdd']) && isset($_GET['ram']) && isset($_GET['cpu'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $vm = $_GET['vm'];
        $hdd = $_GET['hdd'];
        $ram = $_GET['ram'];
		$cpu = $_GET['cpu'];

        //Check if username and password matches
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);
        if($database->affectedRows() == 1){

            echo "<br/>Logged in as: $username <br/>";

            echo "<br/><b>Step 2 of 2</b></br>";

            echo "<br/> Select an OS: <br/>";

            echo "<br/>These are all the orders:";

            echo "<table id=\"customers\">";

            $query = "SELECT * FROM os_dir";
            $vms = $database->getQuery($query);
            if($database->affectedRows() > 1) {
                //Ech the users and give some options to change the users.
                echo "<tr>";
                echo "<th>OS</th>";
                echo  "<th>Choose OS</th>";
                echo "</tr> <br />";
                foreach($vms as $key => $vm1){
                    $os = $vm1['os'];





                    echo "<tr class='alt'>";
                    echo "<td>$os</td>";
                    echo "<td><a href=\"request.php?username=$username&session=$session&vm=$vm&hdd=$hdd&ram=$ram&cpu=$cpu&os=$os\"><INPUT TYPE=\"button\" VALUE=\"Request VM\" Class=\"knop\"></a></td>";
                    echo "</tr>";
                }


            }
            elseif($database->affectedRows() == 1) {
                //Ech the users and give some options to change the users.
                //Ech the users and give some options to change the users.
                echo "<tr>";
                echo "<th>OS</th>";
                echo  "<th>Choose Os</th>";
                echo "</tr> <br />";

                    $os = $vms['os'];





                    echo "<tr class='alt'>";
                    echo "<td>$os</td>";
                    echo "<td><a href=\"sla.php?username=$username&session=$session&vm=$vm&hdd=$hdd&ram=$ram&cpu=$cpu&os=$os\"><INPUT TYPE=\"button\" VALUE=\"Request VM\" Class=\"knop\"></a></td>";
                    echo "</tr>";


            }
				echo "<br />";
                echo "<br />";
                echo "</table> <br />";


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