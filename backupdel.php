<?
/**
 * @author Koen Veelenturf
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

    //Check if the username matches with the session
    if(isset($_GET['username']) && isset($_GET['session'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $vmname = $_GET["vmname"];
        
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);
        
        if($database->affectedRows() == 1){
            echo "<h1>Back-up Settings Modification</h1>";
            echo "<br/>Logged in as: $username <br/>";
            echo "<form method=\"post\" action=\"include/scripts/script.backup.php?username=$username&session=$session&vm=$vmname&action=del\">";
?>
            <table border="0">
                <tr>
                    <td>Are you sure you want to delete the back-up task of VM: <?php echo $vmname; ?>?</td>
                <tr>
                    <td><input type="submit" name="yes" value="Yes" /></td>
                    <td><input type="submit" name="no" value="No" /></td>
                </tr>
            </form>
            </table>
            <div id="dashboard">
                <a href="./poptions.php?username=<?php echo $username; ?>&session=<?php echo $session; ?>">
                    <INPUT TYPE="button" VALUE="Dashboard" Class="knop">
                </a>
            </div><br/>
            <div id="logout">
                <a href="./logout.php?username=<?php echo $username; ?>&session=<?php echo $session; ?>">
                    <INPUT TYPE="button" VALUE="Logout" Class="knop">
                </a>
            </div><br/>
    </body>
</html>
<?php
        }
        else{
            echo "Username or password is incorrect. Or the session has expired.";
        }
    }
    $database->closeConnection();
?>