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
    if (isset($_GET["msg"])) {
        $msg = $_GET["msg"];
    }
?>
   <div id="body">
	<br />
        <form method="post" action="./options.php">
        <table>
            <tr>
                <th colspan="2"><div id="welkommessage">Welcome to the Virtual Machine Management System! <br/><br/>
                        <?php if ($msg == "logout") { echo "You are successfully logged out!<br />"; } ?>

				Login:</div>
				</th>
			</tr>


				<tr>
				<td>Username: </td>
				<td><input type="text" name="username" /></td>
				</tr>

				<tr>
				<td>Password:</td>
				<td><input type="password" name="password" /></td>
				</tr>
				<tr><td></td>
				<td>
				<div id="knopjes">
					<input type="submit" value="Submit" class='knop'></a>
					<input type="reset" value="Reset" class='knop'></a>
				</div>
				</td></tr>


        </table>
       </form>
    <br/>
    </div>
    <div id="signup">
    Didn't sign up yet? Go and <a href="./sign_up.php"><INPUT TYPE="button" VALUE="Sign Up" Class="knop"></a>
	</div>

    </body>
</html>