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
            echo "<form method=\"post\" action=\"include/scripts/script.backup.php?username=$username&session=$session&action=mod\">";
?>
            <table border="0">
                <tr>
                    <td>VM*: </td>
                    <td><select name="vm">
                            <?php $query = "SELECT * FROM backup WHERE vmname = '$vmname'";
                            $vms = $database->getQuery($query);
                            if ($database->affectedRows() > 1) {
                                foreach($vms as $key => $vm1) {
                                    echo "<option>" . $vm1["vmname"] . "</option>";
                                }
                            }
                            elseif ($database->affectedRows() == 1) {
                                echo "<option>" . $vms["vmname"] . "</option>";
                            }
                            else {
                                echo "<option>Geen geldige VM-naam gevonden!</option>";
                            }
?>
                        </select></td>
                </tr>
                <tr>
                    <td>Destination IP-address*: </td>
                    <td><input type="text" name="ipaddress" value="<?php echo $vms["ipaddress"]; ?>" /></td>
                </tr>
                <tr>
                    <td>Username of Destination Host*: </td>
                    <td><input type="text" name="user" value="<?php echo $vms["destinationuser"]; ?>" /></td>
                </tr>
                <tr>
                    <td>When: </td>
                    <td><select name="when1">
                            <option></option>
                            <option>everyday</option>
                            <option>hourly</option>
                            <option>Monday</option>
                            <option>Tuesday</option>
                            <option>Wednesday</option>
                            <option>Thursday</option>
                            <option>Friday</option>
                            <option>Saturday</option>
                            <option>Sunday</option>
                        </select></td>
                    <td>at</td>
                    <td><select name="when2">
                            <option></option>
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>
                        :
                        <select name="when3">
                            <option></option>
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Current time-settings: <?php echo $vms["when1"]; if(!($vms["when2"] == "") AND (!($vms["when3"]) == "")) { echo "(at " . $vms["when2"] . " : " . $vms["when3"] . " )"; } ?></td>
                </tr>
                <tr>
                    <td>How many days of data to keep: </td>
                    <td><input type="text" name="days" value="<?php echo $vms["days"]; ?>" /></td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" /></td>
                    <td><input type="reset" /></td>
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