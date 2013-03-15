<?
/**
 * @author Wouter Miltenburg
 * @version 1.0
  */
?>
<?php
    //include 'include/connections.php';
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
    <br />
<?php

    $database = new Database();
    $database->openConnection();

    //SVN
    //Check if username and password matches.
    if(isset($_POST['username']) && isset($_POST['password'])){
        //Uit de POST methode de gegevens halen, dat is wat meerverzonden wordt uit het formulier
        //Get the data from the POST method, check if everything is sended from the form
        $username = $_POST['username'];
        $password = $_POST['password'];
        //Security layer, encrypt the data with SHA1
        $password2 = sha1($password);
        //$sesion gets a random value from 0 to 2147483647

        $session= rand(0,2147483647);


        //Check if the password matches with the username
        $query = "SELECT username, password FROM admin WHERE username = '$username' AND password = '$password2'";
        $database->getQuery($query);

        if($database->affectedRows() == 1){

            //Update the $session value in the database to the current value of $session
            //Update the random key from $session in the database to the current key
            $query = sprintf("UPDATE admin SET session='$session' WHERE username='$username'");
            $database->doQuery($query);

            echo "Logged in as: $username <br/>";

            $query = "SELECT username, rights FROM admin WHERE username = '$username' AND rights = 1";
            $database->getQuery($query);
            if($database->affectedRows() == 1){

		 echo "

		<div id=\"menu\">
		<div class=\"arrowgreen\">
		<ul>
		<li><a href=\"./poptions.php?username=$username&session=$session\" class=\"selected\" title=\"Admin\">Admin</a></li>
		<li><a href=\"./add.php?username=$username&session=$session\" title=\"Create an user\">Create an user</a></li>
		<li><a href=\"./users.php?username=$username&session=$session\"  title=\"List of users\">List of users</a></li>
		<li><a href=\"./orders_admin.php?username=$username&session=$session\" title=\"Orders\">Orders</a></li>
		<li><a href=\"./user_vm.php?username=$username&session=$session\" title=\"Connect a VM with an user\">Connect a VM with an user</a></li>
		<li><a href=\"./os_admin.php?username=$username&session=$session\" title=\"OS\">OS</a></li>
		<li><a href=\"./admin_package.php?username=$username&session=$session\" title=\"Packages\">Packages</a></li>
		<li><a href=\"./vm.php?username=$username&session=$session\" title=\"Create a VM\">Create a VM</a></li>
		<li><a href=\"./admin_list.php?username=$username&session=$session\" title=\"List all VMs (Admin)\">List all VMs (Admin)</a></li>
		<li><a href=\"./edit_vm_admin.php?username=$username&session=$session\" title=\"Order for changing VM(Admin)\">Order for changing VM(Admin)</a></li>
		<li><a href=\"./mon_tactical.php?username=$username&session=$session\" title=\"Monitoring tool (Admin)\">Monitoring tool (Admin)</a></li>
		</ul>

		";



		echo "<br /><br />

		<ul>
		<li><a href=\"./poptions.php?username=$username&session=$session\" class=\"selected\" title=\"User\">User</a></li>
		<li><a href=\"./list.php?username=$username&session=$session\" title=\"List Virtual Machines\">List Virtual Machines</a></li>
		<li><a href=\"./request_vm.php?username=$username&session=$session\"  title=\"Order a VM \">Order a VM </a></li>
		<li><a href=\"./mon_tactical.php?username=$username&session=$session\" title=\"Monitoring tool\">Monitoring tool</a></li>
		<li><a href=\"./backupnow.php?username=$username&session=$session\" title=\"Back-up Menu\">Back-up Menu</a></li>
		</ul>
		</div>
		</div>
		";

		echo "<div id=\"content\">";

            //echo "Change a virtual machine <a href=\"./vm_user_edit.php?username=$username&session=$session\">click here</a>. <br />";


		echo"

		<br/> <br/><br/> <br/>

		Welcome to the VMMS. You are currently at the VMMS Dashboard.<br/>On the left you can navigate through the system using the menu.
		To Log Out, please press the \"Logout\" button.

		<br/> <br/><br/> <br/>

		If you want to see the SLA-specifications one more time, please press the <a href=\"./add.php?username=$username&session=$session\">
		<INPUT TYPE=\"button\" VALUE=\"SLA Info\" Class=\"knop\"></a> button.

		</div>";

           	}

	     $query = "SELECT username, rights FROM admin WHERE username = '$username' AND rights = 1";
            $database->getQuery($query);
            if($database->affectedRows() !== 1){

		echo "<br /><br />

		<div id=\"menu\">
		<div class=\"arrowgreen\">
		<ul>
		<li><a href=\"./poptions.php?username=$username&session=$session\" class=\"selected\" title=\"User\">User</a></li>
		<li><a href=\"./list.php?username=$username&session=$session\" title=\"List Virtual Machines\">List Virtual Machines</a></li>
		<li><a href=\"./request_vm.php?username=$username&session=$session\"  title=\"Order a VM \">Order a VM </a></li>
		<li><a href=\"./mon_tactical.php?username=$username&session=$session\" title=\"Monitoring tool\">Monitoring tool</a></li>
		<li><a href=\"./backupnow.php?username=$username&session=$session\" title=\"Back-up Menu\">Back-up Menu</a></li>
		</ul>
		</div>
		</div>
		";

		echo "<div id=\"content1\">";



		echo"

		<br/> <br/>

		Welcome to the VMMS. You are currently at the VMMS Dashboard.<br/>On the left you can navigate through the system using the menu.
		To Log Out, please press the \"Logout\" button.

		<br/> <br/><br/> <br/>

		If you want to see the SLA-specifications one more time, please press the <a href=\"./sign_up.php\">
		<INPUT TYPE=\"button\" VALUE=\"Sign Up\" Class=\"knop\"></a> button.

		</div>";


           	}

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
