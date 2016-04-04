<html lang="en" class="no-js">

<head>
  <meta charset="UTF-8">
  <title>304 Hotel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font-->
  <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' >

  <!-- Stylesheets -->
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" media="all" href="css/template.css" >
  <link rel="stylesheet" type="text/css" media="all" href="css/magnific-popup.css" >
  <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">


<!-- Javscripts -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script type="text/javascript" src="js/jquery.magnific-popup.js"></script>
  <script type="text/javascript" src="js/scripts.js"></script>

</head>


<body>

<!-- Top Header / Header Bar -->
<div id="home" class="boxed-view">
    <?php include("header.html");?>

<section class="box">
<div class="container">

<h4 align='center'>Thank you for booking with us, <b><?php echo $_POST["name"]; ?></b> </h4>
 <h3 align='center'>Here is your confirmation number:<b> 

<?php 

$conf = rand(); 
$confn = sprintf('%10d', $conf);
echo $confn; 
?></b><br>
</h3>

Please use your confirmation number to log in to view your reservation at a later time. <br>
Below you will find your reservation confirmation details:<br><br>


<font color='#4fabbc'>Reservation Details:</font><br>
<table style = "width: 100%" border = "2">


<tr>
  <th>Room Number</th>
  <th> From</th>
  <th>To</th>
</tr>
<tr>
  <td><center> <?php echo $_POST["room_no"]; ?></center></td>
  <td><center> <?php echo $_POST["start-date"]; ?> <center></td>
  <td><center> <?php echo $_POST["end-date"]; ?> <center></td>
</tr>
</table>

<font color='#4fabbc'>Customer Confirmation:</font><br>

<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
$conn = oci_connect("ora_e9z7", "a25929100", "ug");


$statement = OCIParse($conn, "INSERT INTO customer (phone, name, age, street, zipcode) values (:bindphone, :bindname, :bindage, :bindstreet, :bindzip)"); 

	if (!$statement) {
		echo "<br>Cannot parse the following command:<br>";
		$e = OCI_Error($conn);
		echo htmlentities($e['message']);
		$success = False;
	}

$phone = $_POST['phone'];
$name = $_POST['name'];
$age = $_POST['age'];
$st = $_POST['street'];
$zip = $_POST['zipcode'];

ocibindbyname($statement, ":bindphone", $phone);
ocibindbyname($statement, ":bindname", $name);
ocibindbyname($statement, ":bindage", $age);
ocibindbyname($statement, ":bindstreet", $st);
ocibindbyname($statement, ":bindzip", $zip);
	
$r = OCIExecute($statement);
if (!$r) {
			echo "<br>Cannot execute the following command<br>";
			$e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
			echo htmlentities($e['message']);
			echo "<br>";
			$success = False;
		}
oci_free_statement($statement);

OCICommit($conn);


$after = oci_parse($conn, 'SELECT * FROM customer c where c.phone = :bindphone');
if (!$after) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$phone = $_POST['phone'];
ocibindbyname($after, ":bindphone", $phone);

$r = oci_execute($after);
if (!$r) {
    $e = oci_error($after);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

print "<table id = 'employ' class = 'display' cellspacing ='0' >\n";
print "<thead>\n";
print "<tr>\n";
print "<th>Phone</th><th>Name</th><th>Age</th><th>Street</th><th>Zipcode</th>\n";
print "</tr>\n";
print "<tbody>";
while ($row = oci_fetch_array($after, OCI_ASSOC+OCI_RETURN_NULLS)) {
    print "<tr>\n";
    foreach ($row as $item) {
        print "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    }
    print "</tr>\n";
}
print "</tbody>";
print "</table>\n";

oci_free_statement($after);

?>

<font color='#4fabbc'>Reservation Confirmation:</font><br>

<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
$conn = oci_connect("ora_e9z7", "a25929100", "ug");


$reservation = OCIParse($conn, "INSERT INTO reservation (conf_no, room_no, card_name, card_type, card_no, exp_date, phone, from_date, to_date) 
  values (:bindconf, :bindroom, :bindcname, :bindtype, :bindno, :bindexp, :bindphone, :bindfrom, :bindto)"); 

  if (!$reservation) {
    echo "<br>Cannot parse the following command:<br>";
    $e = OCI_Error($conn);
    echo htmlentities($e['message']);
    $success = False;
  }

$originalFromDate = $_POST["start-date"];
$newFromDate = date("y-m-d", strtotime($originalFromDate));

$originalToDate = $_POST["end-date"];
$newToDate = date("y-m-d", strtotime($originalToDate));

$originalExpDate = $_POST["exp_date"];
$newExpDate = date("y-m-d", strtotime($originalExpDate));
//reservation add

$conf = $confn;
$room = $_POST['room_no'];
$cname = $_POST['card_name'];
$type = $_POST['card_type'];
$no = $_POST['card_no'];
$exp = $newExpDate;
$ph = $_POST['phone'];
$from = $_POST['start-date'];
$to = $_POST['end-date'];

ocibindbyname($reservation, ":bindconf", $conf);
ocibindbyname($reservation, ":bindroom", $room);
ocibindbyname($reservation, ":bindcname", $cname);
ocibindbyname($reservation, ":bindtype", $type);
ocibindbyname($reservation, ":bindno", $no);
ocibindbyname($reservation, ":bindexp", $exp);
ocibindbyname($reservation, ":bindphone", $ph);
ocibindbyname($reservation, ":bindfrom", $from);
ocibindbyname($reservation, ":bindto", $to);
  
$r = OCIExecute($reservation);
if (!$r) {
      echo "<br>Cannot execute the following command<br>";
      $e = OCI_Error($reservation); // For OCIExecute errors pass the statementhandle
      echo htmlentities($e['message']);
      echo "<br>";
      $success = False;
    }
oci_free_statement($reservation);

OCICommit($conn);

//confirmation

$confirmation = oci_parse($conn, 'SELECT * FROM reservation c where c.conf_no = :bindconf');
if (!$confirmation) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$conf = $confn;
ocibindbyname($confirmation, ":bindconf", $conf);

$r = oci_execute($confirmation);
if (!$r) {
    $e = oci_error($confirmation);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

print "<table id = 'employ' class = 'display' cellspacing ='0' >\n";
print "<thead>\n";
print "<tr>\n";
print "<th>ConfNo</th><th>RoomNo</th><th>Name</th><th>Type</th><th>No</th><th>ExpDate</th><th>Added</th><th>Time</th><th>Phone</th><th>From</th><th>To</th>\n";
print "</tr>\n";
print "<tbody>";
while ($row = oci_fetch_array($confirmation, OCI_ASSOC+OCI_RETURN_NULLS)) {
    print "<tr>\n";
    foreach ($row as $item) {
        print "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    }
    print "</tr>\n";
}
print "</tbody>";
print "</table>\n";

oci_free_statement($confirmation);



oci_close($conn);


?>

 <script>
  $(function(){
    $('table.display').dataTable({
		order: []
	});
	$(".dataTables_wrapper").css("width","100%");
  })
  </script>

</div>
<?php include("footer.html");?>
</body>



</html>