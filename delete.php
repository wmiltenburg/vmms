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

        //Kijken of de session overeenkomt met de username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);
        if($database->affectedRows() == 1){
            echo "</br>Logged in as: $username <br/>";

            $query = "SELECT username FROM admin WHERE username = '$user'";
            $database->getQuery($query);
            if($database->affectedRows() == 1){
                echo "<br/>User exists and trying to delete him from the database <br />";

                $query = sprintf("DELETE FROM admin WHERE username = '$user'");
                $database->doQuery($query);

                echo "<br/>User $user is deleted from the tabel admin <br/>";

                $query2 = sprintf("DELETE FROM user_vm WHERE username = '$user'");
                $database->doQuery($query2);

                echo "<br/>User $user is deleted from the tabel user_vm <br/>";
                echo "<br/>User $login is removed<br /><br/>";


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
                echo "User $user doesn't exist.";
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
