<html>
<head>


  <script type="text/javascript" charset="utf8" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js"></script>
  
  

 </head>
 
<body>


<div class="viewlist" align = 'center'>
<p>
    <button type ="button" onclick="toggleView('reserve')">Reservations</button>
    <button type ="button" onclick="toggleView('cust')">Customers</button>
    <button type ="button" onclick="toggleView('room')">Rooms</button>
	<button type ="button" onclick="toggleView('hotel')">Hotel Information</button>
	<button onClick="window.location='index.php'">Log Out </button>
</p>
</div>

<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
$conn = oci_connect("ora_n9b9", "a40798126", "ug");
$query1 = 'SELECT * FROM customer c, zipcodecitystate z WHERE c.zipcode = z.zipcode ORDER BY name';
$query2 = 'SELECT room.*, bedroom_type_name FROM room LEFT OUTER JOIN bedroom on room.roomno = bedroom.roomno';
$query3 = 'SELECT r.*, room.type FROM reservation r, room where r.room_no = room.roomno';
$query4 = "SELECT floorno, sum(capacity), count(*) FROM room group by floorno";
$query8 = "select conf_no, room_no, card_name from reservation where conf_no not in (select conf_no from checkout)";
$query9 = "SELECT * from checkout";
if (!$conn){
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

function execute($query){
	global $conn;
	$stid = oci_parse($conn, $query);
	if (!$stid) {
		$e = oci_error($conn);
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	$r = oci_execute($stid);
	if (!$r) {
		$e = oci_error($stid);
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
		
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
		print "<tr>\n";
		foreach ($row as $item) {
			print "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
		}
		print "</tr>\n";
	}
	print "</tbody>";
	print "</table>\n";

	oci_free_statement($stid);	
}
?>

<div class = "alltable" id = "reserve">
<?php

if (array_key_exists('delete', $_POST)) {
	$conf_no =  $_POST['deleteval'];
	$query7 = "delete from reservation where conf_no= " . $conf_no;
	$statement = oci_parse($conn, $query7);
	$r = OCIExecute($statement);
	if (!$r) {
		  echo "<br>Cannot execute the following command<br>";
		  $e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
		  echo htmlentities($e['message']);
		  echo "<br>";
		  $success = False;
		}
	oci_free_statement($statement);
}

if (array_key_exists('checkin', $_POST)) {
	$conf_no =  $_POST['checkinval'];
	$query8 = "update reservation set checkin_timestamp = systimestamp where conf_no= " . $conf_no;
	$statement = oci_parse($conn, $query8);
	$r = OCIExecute($statement);
	if (!$r) {
		  echo "<br>Cannot execute the following command<br>";
		  $e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
		  echo htmlentities($e['message']);
		  echo "<br>";
		  $success = False;
		}
	oci_free_statement($statement);
}

if (array_key_exists('checkout', $_POST)) {
	$conf_no =  $_POST['conf'];
	$extra =  $_POST['extra'];
	$damage =  $_POST['damage'];
	
	$query10 = "insert into checkout values(" . $conf_no . "," . $extra . ", systimestamp," . $damage . ")";
	$statement = oci_parse($conn, $query10);
	$r = OCIExecute($statement);
	if (!$r) {
		  echo "<br>Cannot execute the following command<br>";
		  $e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
		  echo htmlentities($e['message']);
		  echo "<br>";
		  $success = False;
		}
	oci_free_statement($statement);
}

if($conn){
	print "<h1 align = 'center'>Reservations</h1>";
	print "<table id = 'employ4' class = 'display' cellspacing ='0' >\n";
	print "<thead>\n";
	print "<tr>\n";
	print "<th>Confirmation</th><th>Room No.</th><th>Card Name</th><th>Card Type</th><th>Card No.</th><th>Card Expiry</th><th>Date Booked</th><th>Time Checked In</th><th>Phone</th><th>Start Date</th><th>End Date</th><th>Type</th><th>Checkin</th><th>Delete</th>\n";
	print "</tr>\n";
	print "<tbody>";
	global $conn;
	$stid = oci_parse($conn, $query3);
	if (!$stid) {
		$e = oci_error($conn);
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	$r = oci_execute($stid);
	if (!$r) {
		$e = oci_error($stid);
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
		
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
		print "<tr>\n";
		foreach ($row as $item) {
			print "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
		}
		print "<td><form action='employee.php' method='POST'><input type='hidden' name='checkinval' value='".$row["CONF_NO"]."'/><input type='submit' name='checkin' value='Checkin' /></form></td>\n";
		print "<td><form action='employee.php' method='POST'><input type='hidden' name='deleteval' value='".$row["CONF_NO"]."'/><input type='submit' name='delete' value='Delete' /></form></td>\n";
		print "</tr>\n";
	}
	print "</tbody>";
	print "</table>\n";

	oci_free_statement($stid);	
}
?>

<form method="POST" action="employee.php">
   <p><input type="text" placeholder="Confirmation No." name="conf"><input type="number" placeholder="Extra Costs" name="extra"><input type="number" placeholder="Damage Costs" name="damage">
<input type="submit" value="Checkout" name="checkout"></p>
</form>

<?php
	print "<br>";
	print "<h1 align = 'center'>Checked Out Customers</h1>";
	print "<table id = 'employ5' class = 'display' cellspacing ='0' >\n";
	print "<thead>\n";
	print "<tr>\n";
	print "<th>Confirmation Number</th><th>Extra Cost</th><th>Checked Out</th><th>Damage Cost</th>\n";
	print "</tr>\n";
	print "<tbody>";
	execute($query9);
?>
</div>


<div class = "alltable" id = "cust">
<?php

if ($conn){
	print "<h1 align = 'center'>Customers</h1>";
	print "<table id = 'employ2' class = 'display' cellspacing ='0' >\n";
	print "<thead>\n";
	print "<tr>\n";
	print "<th>Phone</th><th>Name</th><th>Age</th><th>Street</th><th>Zipcode</th><th>City</th><th>Province</th>\n";
	print "</tr>\n";
	print "<tbody>";
	execute($query1);
}
?>
<br>
<button id = "importantcust" name = "importantcust" onClick = "showMaxMin('importantcust')">Show/Hide Important Customers</button>
<br>Customers who are currently reserving all types of rooms (bedroom, conference room and ballroom)</br>

<div id="resultbestcust"><b></b></div>

</div>



<div class = "alltable" id = "room">

<?php
	print "<h1 align = 'center'>Rooms</h1>";
	print "<table id = 'employ3' class = 'display' cellspacing ='0' >\n";
	print "<thead>\n";
	print "<tr>\n";
	print "<th>Room Number</th><th>Floor</th><th>Smoking</th><th>Pets</th><th>Availability</th><th>Capacity</th><th>Type</th><th>Class</th>\n";
	print "</tr>\n";
	print "<tbody>";
	execute($query2);
?>

</div>



<div class = "alltable" id = "hotel">

<?php
	print "<h1 align = 'center'>Hotel Information</h1>";
	print "<table id = 'employ1' class = 'display' cellspacing ='0' >\n";
	print "<thead>\n";
	print "<tr>\n";
	print "<th>Floor No.</th><th>Capacity</th><th># of Rooms</th>\n";
	print "</tr>\n";
	print "<tbody>";
	execute($query4);
?>



Floor(s) with 

<select name = "availrooms" onchange ="showMaxMin(this.value)">
  <option class="placeholder" selected disabled value="">Select..</option>
  <option value="max">Maximum</option>
  <option value="min">Minimum</option>
</select>
available capacity:


<br>
<div id="resultavail"><b></b></div>

</div>

<?php

if($conn){
	OCILogoff($conn);
}
?>
 <script>
  $(function(){
    $('#employ1').dataTable({
		order: []
	});
	$('#employ2').dataTable({
		order: []
	});
	$('#employ3').dataTable({
		order: [],
		"columnDefs":[
		{
			"targets": [4],
			"visible": false,
			"searchable": false
		}
		]
	});
	$('#employ4').dataTable({
		order: []	
	});
	
	$('#employ5').dataTable({
		order: []	
	});
  })
  
	function toggleView(id){
		$('.alltable').hide();
		$('#' +id).show();
	}
  $('.alltable').hide();
  $('#reserve').show();
  $('#resultbestcust').hide();
  
  
  $('#importantcust').click(function(){
	  $('#resultbestcust').toggle();
  })
  </script>
  
  
 <script>
function showMaxMin(v) {
	var result = "";
	
	if (v == "max" || v == "min"){
		result = "resultavail";
	}
	if (v == "importantcust"){
		result = "resultbestcust";
	}
    if (v == "") {
        document.getElementById(result).innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(result).innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","empajax.php?q="+v,true);
        xmlhttp.send();
    }
}
</script>

<style>
select > .placeholder {
  display: none;
}
div.alltable {
  width: 700px ;
  margin: 0 auto;
}
</style>

</body>
</html>
