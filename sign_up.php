<?
/**
 * @author Wouter Miltenburg
 * @version 1.0
  */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
    require_once 'include/classes/database.class.php';
?>
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
    $database = new Database();
    $database->openConnection();
?>
<div id="body">
    <br />
        <form method="post" action="./add_sign.php">
        <table>
            <tr>
                <th colspan="2">Create your account: </th>
            </tr>
            <tr>
				<td>Username:</td>
				<td><input type="text" name="login" /></td>
				</tr>

				<tr>
				<td>Password:</td>
				<td><input type="password" name="password" /></td>
				</tr>

				<tr>
				<td>Password (again): </td>
				<td><input type="password" name="password2" /></td>
				</tr>

				<tr>
				<td>Firstname: </td>
				<td><input type="text" name="name" /></td>
				</tr>

				<tr>
				<td>Surname: </td>
				<td><input type="text" name="lname" /></td>
				</tr>

				<tr>
				<td>E-mail: </td>
				<td><input type="text" name="mail" /></td>
				</tr>

				<tr>
				<td>Phone: </td>
				<td><input type="text" name="phone" /></td>
				</tr>

				<tr>
				<td>SLA: </td>
				<td><select name="sla">
					<?php

						$query = "SELECT sla FROM sla";
						$vms = $database->getQuery($query);
						if ($database->affectedRows() > 1) {
							foreach($vms as $key => $vm1) {
								$sla_type = $vm1['sla'];
								echo "<option value=\"$sla_type\">$sla_type</option>";
						}
						}elseif ($database->affectedRows() == 1) {
							$sla_type = $vms['sla'];
							echo "<option value=\"$sla_type\">$sla_type</option>";
					}
					?>
				</select></td>
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
            <tr>
                <td colspan="2"></td>
            </tr>
        </table>
       </form>
    <br/>

		  <table id="customers1">

                <tr>
                <th>SLA</th>
                <th>RAM</th>
                <th>CPU speed</th>
                <th>HDD</th>
                <th>Back-up Space</th>
		  <th>Back-up frequency</th>
                <th>Uptime guarantee %</th>
                <th>Number of VMs</th>
                </tr> <br />

		  <tr class='alt'>
                <td><img src="images/Gold.png" width="35" height="35" alt="Gold" /><br/> Gold</td>
                <td>8 GB</td>
                <td>3 GHZ</td>
                <td>100 GB</td>
                <td>250 GB</td>
		  <td>Daily + incemental back-up every hour</td>
                <td>99%</td>
                <td>50</td>
                </tr>

		  <tr class='alt'>
                <td><img src="images/Silver.png" width="35" height="35" alt="Silver" /><br/> Silver</td>
                <td>4 GB</td>
                <td>1 GHZ</td>
                <td>25 GB</td>
                <td>50 GB</td>
		  <td>Daily + incemental back-up every day</td>
                <td>98.5%</td>
                <td>25</td>
                </tr>

		  <tr class='alt'>
                <td><img src="images/Bronze.png" width="35" height="35" alt="Bronze" /><br/> Bronze</td>
                <td>2 GB</td>
                <td>512 MHZ</td>
                <td>10 GB</td>
                <td>10 GB</td>
		  <td>Weekly + incemental back-up every day</td>
                <td>98%</td>
                <td>10</td>
                </tr>

		  <tr class='alt'>
                <td><img src="images/Special.png" width="35" height="35"  /><br/> Special</td>
                <td>Custom</td>
                <td>Custom</td>
                <td>Custom</td>
                <td>Custom</td>
		  <td>Custom</td>
                <td>Custom</td>
                <td>Custom</td>
                </tr>

		  <tr><td colspan="8"><br/><b>Contact Plaintech to construct a special SLA</b></td></tr>

		 <br />
               </table> <br />


	  <div id="logout">
        <a href="./index.php">
        <INPUT TYPE="button" VALUE="Cancel" Class="knop">
        </a>
        </div>
        <br/>

    </div>

    </body>
</html>