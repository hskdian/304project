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

<h4 align='center'>Thanks for Booking!<h4>
  <h3 align='center'>Please enter your information below: </h3>

<?php 

$startDate = $_GET['start-date'];
$endDate = $_GET['end-date'];
$room_no =$_GET['room-no'];
$roomType = $_GET['room-type'];
$rate = $_GET['rate'];

?>


<div class="row">
  <div class="col-md-12 col-sm-6">
    <table class='display' cellspacing='0' max-width='100%' >
  <tr>
    <th>Dates Requested</th>
    <th>Total</th>
  </tr>
  <tr>
    <td><center><?php echo $startDate?> - <?php echo $endDate?></center></td>
    <td><center>Number of Nights: 
<?php 

function dateDiff($dformat, $endDate, $beginDate)
{
    $date_parts1=explode($dformat, $beginDate);
    $date_parts2=explode($dformat, $endDate);
    $start_date=gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
    $end_date=gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
    return $end_date - $start_date;
}

// mm-dd-yyyy
$date1= date("m-y-d", strtotime($startDate));
$date2 = date("m-y-d", strtotime($endDate));
$date3 = dateDiff("-", $date2, $date1);

echo $date3;

?>
      <br>
          Rate: $<?php echo $rate;
          ?><br>
          Total: $<?php 

          if (strcmp($roomType, 'bedroom') == 0){

          echo $rate ?> x $<?php echo $date3 ?> = $<?php echo ($rate * $date3);
        }

          else{

          echo $rate ?> x <?php echo $date3 ?> days x 24 hours = $<?php echo ($rate * $date3 * 24);

          }

?></center></td> 
  </tr>
</table>
</div>
</div>


<div class="row">
<div class="col-md-12 col-sm-6">
<form action="reservation.php" method="post">

<input type = "hidden" name = 'start-date' value = <?php echo $startDate ?>><br>
<input type = "hidden" name = 'end-date' value = <?php echo $endDate ?>><br>
<input type = "hidden" name = 'room_no' value = <?php echo $room_no ?>><br>

<b>Name: </b><input type="text" name="name" required><br>
<b>Age:</b> <input type="text" name="age" required><br>
<b>Street:</b> <input type="text" name="street" required><br>
<b>Zipcode:</b> <input type="text" value = "XXX XXX"name="zipcode" required><br>


<b>Name on Card:</b> <input type="text" name="card_name" required><br>

<b>Card Type:   </b><select name = "card_type" required>
    <option value = "VISA"> VISA </option>
    <option value = "MasterCard">MASTERCARD </option>
    </select><br>

<b>Card Number:</b> <input type="text" name="card_no" required><br>

<b>Expirary Date:</b> <input type="text" value = 'DD-Mon-YY'name="exp_date" required><br>
<!-- Added Date: <input type="text" name="added_date"><br>
CheckIn Time: <input type="text" name="checkin_timestamp"><br>
 -->

<b>Phone: </b><input type="text" value = "XXX-XXX-XXXX" name="phone" required><br>
<br>

<center><input type="checkbox" value="Bike" required>I confirm that the information above is correct<br></center>
 <br>

<center><button class="btn button-md green hover-dark-green soft-corners" type="submit">Submit</button></center>
</form></div>

</div>
</div>

</section>

<?php include("footer.html");?>

</body>



</html>
