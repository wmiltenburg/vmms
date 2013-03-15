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
    if(isset($_GET['username']) && isset($_GET['session'])){

        $username = $_GET['username'];
        $session = $_GET['session'];

        //Check if username and password matches
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);
        if($database->affectedRows() == 1){

            echo "<br/>Logged in as: $username <br/>";

            echo "<br/><b>Step 1 of 2</b><br/>";

            echo "<br/>Virtual Machines: <br/>";

            $query2 = "SELECT sla FROM admin WHERE username = '$username'";
            $sla_user = $database->getQuery($query2);
            $sla_username = $sla_user['sla'];

            echo "<br/>These are all the orders:<br />";

            echo "<table id=\"customers\">";

            $query = "SELECT * FROM vm_package";
            $vms = $database->getQuery($query);
            if($database->affectedRows() > 1) {
                //Ech the users and give some options to change the users.
                echo "<tr>";
                echo "<th>Package</th>";
                echo "<th>HDD</th>";
                echo "<th>RAM</th>";
                echo "<th>CPU</th>";
                echo "<th>Choose OS</th>";
                echo "</tr> <br />";
                foreach($vms as $key => $vm1){
                    $vm = $vm1['name'];
                    $hdd = $vm1['hdd'];
                    $ram = $vm1['ram'];
                    $cpu = $vm1['cpu'];
                    $sla = $vm1['sla'];
                    //echo "$sla";

                   echo "<tr class='alt'>";
                    echo "<td>$vm</td>";
                    echo "<td>$hdd</td>";
                    echo "<td>$ram</td>";
                    echo "<td>$cpu</td>";


                    if($sla_username == $sla){
                     echo "<td><a href=\"os.php?username=$username&session=$session&vm=$vm&hdd=$hdd&ram=$ram&cpu=$cpu\"><INPUT TYPE=\"button\" VALUE=\"Choose OS\" Class=\"knop\"></a></td>";
                    }elseif($sla_username == 'silver' && $sla == 'bronze'){
                        echo "<td><a href=\"os.php?username=$username&session=$session&vm=$vm&hdd=$hdd&ram=$ram&cpu=$cpu\"><INPUT TYPE=\"button\" VALUE=\"Choose OS\" Class=\"knop\"></a></td>";
                    }elseif($sla_username == 'gold' && $sla == 'bronze'){
                        echo "<td><a href=\"os.php?username=$username&session=$session&vm=$vm&hdd=$hdd&ram=$ram&cpu=$cpu\"><INPUT TYPE=\"button\" VALUE=\"Choose OS\" Class=\"knop\"></a></td>";
                    }elseif($sla_username == 'gold' && $sla == 'silver'){
                         echo "<td><a href=\"os.php?username=$username&session=$session&vm=$vm&hdd=$hdd&ram=$ram&cpu=$cpu\"><INPUT TYPE=\"button\" VALUE=\"Choose OS\" Class=\"knop\"></a></td>";
                    }elseif($sla_username == 'special'){
                       echo "<td><a href=\"os.php?username=$username&session=$session&vm=$vm&hdd=$hdd&ram=$ram&cpu=$cpu\"><INPUT TYPE=\"button\" VALUE=\"Choose OS\" Class=\"knop\"></a></td>";
                    }else{
                        echo "<td>not allowed</td>";
                    }
                    echo "</tr>";
                }


            }
            elseif($database->affectedRows() == 1) {
                //Ech the users and give some options to change the users.
              //Ech the users and give some options to change the users.
                echo "<tr>";
                echo "<th>Package</th>";
                echo "<th>HDD</th>";
                echo  "<th>RAM</th>";
				echo  "<th>CPU</th>";
                echo  "<th>Choose OS</th>";
                echo "</tr> <br />";

                    $vm = $vms['name'];
                    $hdd = $vms['hdd'];
                    $ram = $vms['ram'];
                    $cpu = $vms['cpu'];
                    $sla = $vms['sla'];
                    //echo "$sla";

                    echo "<tr class='alt'>";
                    echo "<td>$vm</td>";
                    echo "<td>$hdd</td>";
                    echo "<td>$ram</td>";
                    echo "<td>$cpu</td>";

                if($sla_username == $sla){
                    echo "<td><a href=\"os.php?username=$username&session=$session&vm=$vm&hdd=$hdd&ram=$ram\"><INPUT TYPE=\"button\" VALUE=\"Choose OS\" Class=\"knop\"></a></td>";
                    }elseif($sla_username == 'silver' && $sla == 'bronze'){
                        echo "<td><a href=\"os.php?username=$username&session=$session&vm=$vm&hdd=$hdd&ram=$ram\"><INPUT TYPE=\"button\" VALUE=\"Choose OS\" Class=\"knop\"></a></td>";
                    }elseif($sla_username == 'gold' && $sla == 'bronze'){
                        echo "<td><a href=\"os.php?username=$username&session=$session&vm=$vm&hdd=$hdd&ram=$ram\"><INPUT TYPE=\"button\" VALUE=\"Choose OS\" Class=\"knop\"></a></td>";
                    }elseif($sla_username == 'gold' && $sla == 'silver'){
                        echo "<td><a href=\"os.php?username=$username&session=$session&vm=$vm&hdd=$hdd&ram=$ram\"><INPUT TYPE=\"button\" VALUE=\"Choose OS\" Class=\"knop\"></a></td>";
                    }elseif($sla_username == 'special'){
                        echo "<td><a href=\"os.php?username=$username&session=$session&vm=$vm&hdd=$hdd&ram=$ram\"><INPUT TYPE=\"button\" VALUE=\"Choose OS\" Class=\"knop\"></a></td>";
                    }else{
                        echo "<td>not allowed</td>";
                    }
                    echo "</tr>";
            }
            echo "<br />";
                echo "";
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

                    </td>
            </tr>
        </table>
    </form>
    </body>
</html>