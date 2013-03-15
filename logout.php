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

    //Check if everything is filled in correctly
    if(isset($_GET['username']) && isset($_GET['session'])){
    $username = $_GET['username'];
    $session = $_GET['session'];



        //Check if username and password matches
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);
        if($database->affectedRows() == 1){
            $session= rand(0,2147483647);
            $query = "UPDATE admin SET session='$session' WHERE username='$username'";
            $database->doQuery($query);
            /*
             * Before logging out there will be created a new random session id.
             * This new id won't be showed in the url.
             * So when the user goes back with the old id, the user will see an error.
             */

        } else {
            echo "Username or password is incorrect. Or the session has expired.";
        }

    } else {
        echo "You didn't fill in the form.";
    }
    $database->closeConnection();
    header("Location:./index.php?msg=logout");
?>

		</div>
    </body>
</html>