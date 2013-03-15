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
?>
 	<div id="body">
<?php
    // Including the database class
    require_once('include/classes/database.class.php');

    // Creating database instance
    $database = new Database();
    $database->openConnection();

    //Kijken of $username en $session wel bestaan
    if(isset($_GET['username']) && isset($_GET['session']) && isset($_POST['os']) && isset($_POST['path'])){

        $username = $_GET['username'];
        $session = $_GET['session'];
        $os = $_POST['os'];
        $path = $_POST['path'];




//Kijken of de session overeenkomt met de username
        $query = "SELECT username, session FROM admin WHERE username = '$username' AND session = '$session'";
        $database->getQuery($query);
        if($database->affectedRows() == 1) {

            echo "<br/>Logged in as: $username <br/>";
            $query = "SELECT os FROM os_dir WHERE os = '$os'";
            $database->getQuery($query);
            if($database->affectedRows() != 1){


                //Create a user in table admin
                $query = sprintf("INSERT INTO os_dir (os, path) VALUES ('$os', '$path')");
                $affectedRows = $database->doQuery($query);

                echo "<br/>OS $os is added with path $path<br />
			<br/>";
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



            } else{
                echo "OS $os already exists.";
            }

        } else{
        echo "Username or password is incorrect. Or the session has expired.";
        }

    }else{
        echo "You didn't fill in the form.";
    }
    $database->closeConnection();
?>


    </body>
</html>