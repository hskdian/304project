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

<div class="viewlist">
    <button type ="button" onclick="toggleView('cust')">Customers</button>
    <button type ="button" onclick="toggleView('room')">Rooms</button>
    <button type ="button" onclick="toggleView('reserv')">Reservations</button>
    <button type ="button" onclick="toggleView('hotel')">Hotel Information</button>
	<button type ="button" onclick="">Log Out</button>
</div>


<div class = "alltable" id = "cust">
<h1>Customers</h1>
<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
$conn = oci_connect("ora_n9b9", "a40798126", "ug");

$stid = oci_parse($conn, 'SELECT * FROM customer c, zipcodecitystate z WHERE c.zipcode = z.zipcode ORDER BY name');
if (!$stid) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$r = oci_execute($stid);
if (!$r) {
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

print "<table id = 'employ' class = 'display' cellspacing ='0' >\n";
print "<thead>\n";
print "<tr>\n";
print "<th>Phone</th><th>Name</th><th>Age</th><th>Street</th><th>Zipcode</th><th>City</th><th>Province</th>\n";
print "</tr>\n";
print "<tbody>";
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
oci_close($conn);

?>


</div>

<div class = "alltable" id = "room">
<h1>Rooms</h1>
<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
$conn = oci_connect("ora_n9b9", "a40798126", "ug");

$stid = oci_parse($conn, 'SELECT * FROM room');
if (!$stid) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$r = oci_execute($stid);
if (!$r) {
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

print "<table id = 'employ' class = 'display' cellspacing ='0' >\n";
print "<thead>\n";
print "<tr>\n";
print "<th>Room Number</th><th>Floor</th><th>Smoking</th><th>Pets</th><th>Availability</th><th>Capacity</th><th>Type</th>\n";
print "</tr>\n";
print "<tbody>";
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
oci_close($conn);

?>

</div>

<div class = "alltable" id = "reserv">
<h1>Reservations</h1>
</div>

<div class = "alltable" id = "hotel">
<h1>Hotel Information</h1>
</div>

  <script>
  $(function(){
    $('table.display').dataTable({
		order: []
	});
	$(".dataTables_wrapper").css("width","50%");
  })
  
