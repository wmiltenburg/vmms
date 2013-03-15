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

        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);
        
        if($database->affectedRows() == 1){
            echo "<h1>Back-up Menu</h1>";
            echo "<br/>Logged in as: $username <br/>";

            $query = "SELECT vmname, username, location, when1, ipaddress FROM backup WHERE username = '$username'";
            $backups = $database->getQuery($query);
            
            echo "<br /><h2>List of back-uptasks</h2>";
?>
        <center><a href="backupsettings.php?<?php echo "username=" . $username . "&session=" . $session; ?>&action=add"><img src="images/add.png" alt="Backup Settings" /></a> Add a new Back-up Task</center>
        <table id="customers">
            <?php if($database->affectedRows() >= 1) { ?>
                <tr>
                    <th>VM-name</th>
                    <th>Location back-up-task</th>
                    <th>When?</th>                    
                    <th>Back-up Now!</th>
                    <th>Restore</th>
                    <th>Edit Settings</th>
                    <th>Delete Task</th>
                </tr>
            <?php } else { ?>
                <tr>
                    <th>There are no Back-up Tasks available!</th>
                </tr>
            <?php }
            
            if($database->affectedRows() > 1) {
                foreach($backups as $key => $backup) {
                    $vmname = $backup["vmname"];
                    $location = $backup["location"];
                    $when = $backup["when1"];
                    $ipaddress = $backup["ipaddress"];
                    echo "<tr class=\"alt\">
                        <td>$vmname</td>
                        <td>$location</td>
                        <td>$when</td>
                        <td><a href=\"include/scripts/script.backupnow.php?username=$username&session=$session&location=$location\" /><img src=\"images/start.png\" alt=\"Start!\" /></a></td>
                        <td><a href=\"include/scripts/script.restore.php?username=$username&session=$session&vmname=$vmname&ipaddress=$ipaddress&action=restore\" ><img src=\"images/undo.png\" alt=\"Restore\" /></a></td>
                        <td><a href=\"backup_mod.php?username=$username&session=$session&vmname=$vmname\" ><img src=\"images/edit.png\" alt=\"Edit\"/></a></td>
                        <td><a href=\"backupdel.php?username=$username&session=$session&vmname=$vmname\"><img src=\"images/del.png\"></a></td>
                    </tr>";

                }
            }
        elseif ($database->affectedRows() == 1) {
                $vmname = $backups["vmname"];
                $location = $backups["location"];
                $when = $backups["when1"];
                $ipaddress = $backups["ipaddress"];
                echo "<tr class=\"alt\">
                    <td>$vmname</td>
                    <td>$location</td>
                    <td>$when</td>                
                    <td><a href=\"include/scripts/script.backupnow.php?username=$username&session=$session&location=$location\" /><img src=\"images/start.png\" alt=\"Start!\" /></a></td>
                    <td><a href=\"include/scripts/script.restore.php?username=$username&session=$session&vmname=$vmname&ipaddress=$ipaddress&action=restore\" ><img src=\"./images/undo.png\" alt=\"Restore\" /></a></td>
                    <td><a href=\"backup_mod.php?username=$username&session=$session&vmname=$vmname\" ><img src=\"images/edit.png\" /></a></td>
                    <td><a href=\"backupdel.php?username=$username&session=$session&vmname=$vmname\"><img src=\"images/del.png\"></a></td>
                </tr>";
        }
?>
        </table>
<?php
    } else{
        echo "Username or password is incorrect. Or the session has expired.";
    }
    $database->closeConnection();
}
?>
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