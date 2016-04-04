<html>
<body>
<link rel="stylesheet" type="text/css" href="css/content.css">


<h1>Thank you for Booking! Please enter your information below: </h1>

<?php 

$startDate = $_GET['start-date'];
$endDate = $_GET['end-date'];
$room_no =$_GET['room-no'];


?>

<table style="width:100%">
  <tr>
    <th>Dates Requested</th>
    <th>Total</th>
  </tr>
  <tr>
    <td><center><?php echo $startDate?> - <?php echo $endDate?></center></td>
    <td><center>Number of Nights: <br>
    			Room Rate: <br>
    			Total : </center></td> 
  </tr>
</table>


<form action="reservation.php" method="post">

<input type = "hidden" name = 'start-date' value = <?php echo $startDate ?>><br>
<input type = "hidden" name = 'end-date' value = <?php echo $endDate ?>><br>
<input type = "hidden" name = 'room_no' value = <?php echo $room_no ?>><br>

<b>Name: </b><input type="text" name="name" required><br>
<b>Age:</b> <input type="text" name="age" required><br>
<b>Street:</b> <input type="text" name="street" required><br>
<b>Zipcode:</b> <input type="text" value = "XXX XXXX"name="zipcode" required><br>


<b>Name on Card:</b> <input type="text" name="card_name" required><br>

<b>Card Type: 	</b><select name = "card_type" required>
		<option value = "VISA"> VISA </option>
		<option value = "MasterCard">MASTERCARD </option>
		<option value = "American Express">American Express</option>
		</select><br>

<b>Card Number:</b> <input type="text" name="card_no" required><br>

<b>Expirary Date:</b> <input type="text" value = 'DD-Mon-YY'name="exp_date" required><br>
<!-- Added Date: <input type="text" name="added_date"><br>
CheckIn Time: <input type="text" name="checkin_timestamp"><br>
 -->

<b>Phone: </b><input type="text" value = "xxx-xxx-xxxx" name="phone" required><br>
<br>

<input type="checkbox" value="Bike" required>I confirm that the information above is correct<br>
 <br>

<input type="submit">
</form>

</body>
</html>
