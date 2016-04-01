<?php

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = oci_connect("ora_r4n0b", "a73109150", "ug");
$error = "";
$conf_no = "";

function executeSQL($cmdstr) {
	global $db_conn, $success, $error;
	$statement = OCIParse($db_conn, $cmdstr);

	if (!$statement) {
		$error .= "Cannot parse the following command: " . $cmdstr . "<br>";
	 	$e = OCI_Error($db_conn);
	 	$error .= $e['message'] . "<br>"; 
		$success = False;
		echo $error;
	}

	$r = OCIExecute($statement);
	if (!$r) {
		$error .= "Cannot execute the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
		$error .= $e['message'] . "<br>";
		$success = False;
		echo $error;
	} 

	return $statement;
}

function printCustomer() {
	global $conf_no;
	$query = "select * from reservation,customer,zipcodecitystate where conf_no=" 
			. $conf_no . 
			" and reservation.phone = customer.phone and customer.zipcode = zipcodecitystate.zipcode" ;
	$result = executeSQL($query);
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {		
		$address = $row["ZIPCODE"] . " " . $row["STREET"] . "<br>" . $row["CITY"] . " " . $row["PROVINCE"];
		echo "<tr><td>Name:</td><td>" . $row["NAME"] . "</td></tr>";
		echo "<tr><td>Age:</td><td>" . $row["AGE"] . "</td></tr>";
		echo "<tr><td>Phone:</td><td>" . $row["PHONE"] . "</td></tr>";
		echo "<tr><td>Address:</td><td>" . $address . "</td></tr>";
	}
	unset($result);
}

function printRoom() {
	global $conf_no;
	$query = "select from_date, to_date, (to_date - from_date) as DAYDIFF, reservation.room_no, room.capacity, room.type 
			from reservation,room where conf_no=" 
			. $conf_no . 
			" and reservation.room_no = room.roomno" ;
	$result = executeSQL($query);
	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {	
		$date = strtotime($row["FROM_DATE"]);
		$from_date = date("m/d/y", $date);
		$date = strtotime($row["TO_DATE"]);
		$to_date = date("m/d/y", $date);
		echo "<tr><td>Check In:</td><td>" . $from_date . "</td></tr>";
		echo "<tr><td>Check Out:</td><td>" . $to_date . "</td></tr>";	
		echo "<tr><td>Room No:</td><td>" . $row["ROOM_NO"] . "</td></tr>";
		echo "<tr><td>Capacity:</td><td>" . $row["CAPACITY"] . "</td></tr>";
		$roomtype = $row["TYPE"];
		if (strcmp($roomtype, "bedroom") == 0) {
			//echo "<tr><td>Type:</td><td>" . $roomtype . "</td></tr>";
		  	$query2 = "select bedroom.bedroom_type_name, nightlyprice from bedroom,bedroomtype where bedroom.roomno=" . $row["ROOM_NO"]
		  	. " and bedroomtype.bedroom_type_name = bedroom.bedroom_type_name";
		  	//echo $query2;
		  	$result2 = executeSQL($query2);
		  	$row2 = OCI_Fetch_Array($result2, OCI_BOTH);
		  	$type = $row2["BEDROOM_TYPE_NAME"] . " bedroom";
		  	echo "<tr><td>Type:</td><td>" . $type . "</td></tr>";
		  	$price = $row["DAYDIFF"] * $row2["NIGHTLYPRICE"] * $row["CAPACITY"];
			echo "<tr><td>Total Price:</td><td>" . $price . "</td></tr>";
			unset($result2);
		}
		// } else if (strcmp($row["Type"], "ballroom") == 0 {
		// 	$query2 = "select hourlyprice from ballroom where roomno=" . $row["ROOM_NO"];
		// 	$result2 = executeSQL($query);
		// 	$row2 = OCI_Fetch_Array($result2, OCI_BOTH);
		// 	echo "<tr><td>Type:</td><td>" . $row["TYPE"] . "</td></tr>";
		// 	$price = $row["DAYDIFF"] * $row2["HOURLYPRICE"] * 24;
		// 	echo "<tr><td>Total Price:</td><td>" . $price . "</td></tr>";
		// }
	}
	unset($result);
}

?>



<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
<title>Reservation confirmation</title>
<!-- for-mobile-apps -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="keywords" content="Content Features Widget Responsive, Login form web template, Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<!-- //for-mobile-apps -->
<link href="css/style_confirmation.css" rel="stylesheet" type="text/css" media="all" />
<link href='//fonts.googleapis.com/css?family=Lato:400,100,100italic,300italic,300,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Josefin+Sans:400,100,300,600,700' rel='stylesheet' type='text/css'>
</head>
<body>

<?php
if ($db_conn) {
	if (array_key_exists('conf_no', $_GET)) {
		$conf_no = $_GET['conf_no'];
	}else {
		$error .= "No confirmation number<br>";
		$success = False;
	}
} else {
	$error .= "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	$error .= $e['message'];
	$success = False;
}
?>

<div class="main">
	<h1>Reservation Confirmation</h1>
		<div class="content">
			<div class="features">
				<div class="feature-gd">
					<div class="fea-img">
						<div class="fea-bor">
							<img src="images/icon2.png" alt=" " />
						</div>
					</div>
					<h3>YOUR INFORMATION</h3>
					<table>
						<?php 
						if ($success) {
							printCustomer();
						} 
						?>
					</table>
				</div>
				<div class="feature-gd">
					<div class="fea-img">
						<div class="fea-bor">
							<img src="images/icon3.png" alt=" " />
						</div>
					</div>
					<h3>RESERVATION DETAILS</h3>
					<table>
						<?php
						if ($success) {
							printRoom();
						} 
						?>
					</table>
				</div>
				<div class="feature-gd">
					<div class="fea-img">
						<div class="fea-bor">
							<img src="images/icon1.png" alt=" " />
						</div>
					</div>
					<h3>PLOCIES</h3>
					<p>Nemo enim ipsam voluptatem 
					quia voluptas sit aspernatur 
					aut odit aut fugit, sed quia 
					consequuntur magni dolores eos qui
					ratione. </p>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<p class="footer">© 2016 Content Features Widget. All Rights Reserved | Design by <a href="https://w3layouts.com/" target="_blank">W3layouts</a></p>
</div>
</body>
</html>


<?php
if ($db_conn) {
	oci_close($db_conn);
}
?>