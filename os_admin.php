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
        <title><? include 'include/title.php'; ?></title>
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
    if(isset($_GET['username']) && isset($_GET['session'])){

        $username = $_GET['username'];
        $session = $_GET['session'];

        //Check if the session matches with the username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session' AND rights = 1";
        $database->getQuery($query);

        if($database->affectedRows() == 1){

            echo "<br />These are all the orders:";
            echo "<table id=\"customers\">";

            $query = "SELECT * FROM os_dir";
            $vms = $database->getQuery($query);
            if($database->affectedRows() > 1) {
                //Ech the users and give some options to change the users.
                echo "<tr>";
                echo "<th>OS</th>";
                echo "<th>Path</th>";
                echo "<th>Change</th>";
                echo  "<th>Delete</th>";

                echo "</tr> <br />";
                foreach($vms as $key => $vm1){
                    $os = $vm1['os'];
                    $path = $vm1['path'];

                    echo "<tr class='alt'>";
                    echo "<td>$os</td>";
                    echo "<td>$path</td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$os&command=os_change\"><img src=\"images/edit.png\" alt=\"Edit\" /></a></td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$os&command=os_delete\"><img src=\"images/del.png\" alt=\"Delete\" /></a></td>";
                    echo "</tr>";
                }
            }
            elseif($database->affectedRows() == 1) {
                //Ech the users and give some options to change the users.
                echo "<th>OS</th>";
                echo "<th>Path</th>";
                echo "<th>Change</th>";
                echo  "<th>Delete</th>";

                $os = $vms['os'];
                $path = $vms['path'];


                echo "<tr class='alt'>";
                    echo "<td>$os</td>";
                    echo "<td>$path</td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$os&command=os_change\"><img src=\"images/edit.png\" alt=\"Edit\" /></a></td>";
                    echo "<td><a href=\"confirm.php?username=$username&session=$session&user=$os&command=os_delete\"><img src=\"images/del.png\" alt=\"Delete\" /></a></td>";
                echo "</tr>";
            } else {
                echo "<tr><td>There are no OS available in the database!</td></tr>";
            }
            echo "<br />";
                echo "<br />";
                echo "</table> <br />";


    echo "<form method=\"post\" action=\"./os_add.php?username=$username&session=$session\">";
                ?>
        <table>
            <tr>
            <th colspan="2">Add OS:</th>
            </tr>

				<tr>
				<td>OS: </td>
				<td><input type="text" name="os" /></td>
				</tr>

				<tr>
				<td>Path: </td>
				<td><input type="text" name="path" /></td>
				</tr>

				<tr>
				<td></td>
				<td>
				<br/>

					<input type="submit" value="Submit" class='knop'></a>
					<input type="reset" value="Reset" class='knop'></a>

                <br/>
				</td>
				</tr>

        </table>
       </form>

   <?php
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