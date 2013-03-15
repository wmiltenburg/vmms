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
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_GET['login'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $login = $_GET['login'];

        //Check if username and password matches
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);
        if($database->affectedRows() == 1){

            echo "<br/>Logged in as: $username <br/>";

            echo "<br />This is a list with your available virtual machines:<br />";

           echo "<table id=\"customers\">";

            $query2 = "SELECT * FROM admin WHERE username = '$login'";
            $vms = $database->getQuery($query2);


                                //Echo the virtual machine that is assigned to an user. And give the user some options
                echo "<tr>";
                echo "<th>Username</th>";
                echo "<th>Name</th>";
                echo "<th>Surname</th>";
                echo  "<th>E-mail</th>";
                echo  "<th>Phone</th>";
                echo "</tr> <br />";

                $uname = $vms['username'];
                $name = $vms['name'];
                $lname = $vms['lname'];
                $mail = $vms['mail'];
                $phone = $vms['phone'];


                echo "<tr class='alt'>";
                echo "<td>$uname</td>";
                echo "<td>$name</td>";
                echo "<td>$lname</td>";
                echo "<td>$mail</td>";
                echo "<td>$phone</td>";
                echo "</tr>";

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