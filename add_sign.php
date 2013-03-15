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
        <?php

    include 'include/ssh_logins.php';
?>
	 <div id="body">
<?php
    // Including the database class
    require_once('include/classes/database.class.php');

    // Creating database instance
    $database = new Database();
    $database->openConnection();

    //Kijken of $username en $session wel bestaan
    if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['sla']) && isset($_POST['name']) && isset($_POST['lname']) && isset($_POST['mail']) && isset($_POST['phone'])){

        $username = $_POST['login'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $sla = $_POST['sla'];
        $name = $_POST['name'];
        $lname = $_POST['lname'];
        $mail = $_POST['mail'];
        $phone = $_POST['phone'];





            $query = "SELECT username FROM admin WHERE username = '$username'";
            $database->getQuery($query);
            if($database->affectedRows() != 1){

                if($password==$password2){
                $password3= sha1($password);

                //Create a user in table admin
                $query = sprintf("INSERT INTO admin (username, password, sla, name, lname, mail, phone) VALUES ('$username', '$password3', '$sla', '$name', '$lname', '$mail', '$phone')");
                $affectedRows = $database->doQuery($query);
                
                
                if (!function_exists("ssh2_connect")) die("function ssh2_connect doesn't exist");

                // log in at server1.example.com on port 22
                /*$sql = mysql_query("SELECT master_ip FROM vm WHERE vm = '$vm'");
                $out = mysql_fetch_assoc($sql);
                $ip = $out['master_ip'];
                 *
                 *
                 *
                 */






                if(!($con = ssh2_connect("$masterip", 22))){
                    echo "fail: unable to establish connection\n";
                } else {
                    // try to authenticate with username root, password secretpassword
                    if(!ssh2_auth_password($con, "$ssh_login", "$ssh_password")) {
                        echo "fail: unable to authenticate\n";
                    } else {
                        // allright, we're in!
                        echo "<br/>Adding the user for Nagios. <br/>";

                            // execute a command
                             if (!($stream = ssh2_exec($con, "sudo htpasswd -b /usr/local/nagios/etc/htpasswd.users $username $password" ))) {
                            echo "<br/>fail: unable to execute command\n";

                            } else {
                                // collect returning data from command
                                stream_set_blocking($stream, true);
                                $data = "";
                                while ($buf = fread($stream,4096)) {
                                    $data .= $buf;

                                }
                                fclose($stream);
                            }
                    }
                }
                

                echo "User $username is added with SLA: $sla<br />";
                echo "<br/><a href=\"./index.php\"><INPUT TYPE=\"button\" VALUE=\"Login\" Class=\"knop\"></a>.";

                } else{
                echo "Passwords don't match";
                }

            } else{
                echo "User $username already exists.";
            }



    }else{
        echo "You didn't fill in the form.";
        
        }
    $database->closeConnection();
?>

	  </div>
    </body>
</html>