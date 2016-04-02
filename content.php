<html>
<body>
<h>Thanks for Booking! Please enter your information below: </h>

<?php 

$startDate = $_GET['start-date'];
$endDate = $_GET['end-date'];
$room_no =$_GET['room-no'];

echo $startDate;
echo $endDate;
echo $room_no;

?>


<form action="reservation.php" method="post">
Name: <input type="text" name="name"><br>
Age: <input type="text" name="age"><br>
Street: <input type="text" name="street"><br>
Zipcode: <input type="text" name="zipcode"><br>
<h1> Reservation Confirmation </h1>
Confermation Number:<input type="text" name="conf_no"><br>

Room Number: <?php echo $room_no ?>

<!--<input type="text" name="room_no"><br> -->

Name on Card: <input type="text" name="card_name"><br>
Card Type: <input type="text" name="card_type"><br>
Card Number: <input type="text" name="card_no"><br>

Expirary Date (DD-MON-YY): <input type="text" name="exp_date"><br>
Added Date: <input type="text" name="added_date"><br>
CheckIn Time: <input type="text" name="checkin_timestamp"><br>


Phone: <input type="text" value = "xxx-xxx-xxxx" name="phone"><br>

From: <input type="text" name="from_date"><br>
To: <input type="text" name="to_date"><br>


<input type="submit">
</form>

</body>
</html>
