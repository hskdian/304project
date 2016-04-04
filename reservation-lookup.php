<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Reservation lookup</title>
    <link rel="stylesheet" href="css/style.css">
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
  </head>
  <body>
    <form action="confirmation.php" method="POST" name="reservation_lookup">
      <div class="header">
         <p>Reservation Look Up</p>
      </div>
      <div class="description">
        <p>View, change or cancel your hotel reservation</p>
      </div>
      <div class="input">
        <input type="text" class="button" id="conf_no" name="conf_no" placeholder="Confirmation Number(10 characters)" 
         title="10 digits" required>
        <input type="submit" class="button" name="lookup" id="submit" value="View Reservation">
      </div>
    </form>
  </body>
</html>