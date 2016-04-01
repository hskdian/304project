<!DOCTYPE html>
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

    <!-- main content -->
		<section class="slider-box">
			<div class="slider-mask"></div>
			<div class="simple-slider">
			    <ul class="clean-list">
			    	<li><a href="#"><img src="images/home.jpg"/></a></li>
			    </ul>
			</div>
			<div class="container custom-controls">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="slider-helper">
							<ul class="clean-list">
								<li class="text-white text-center">
									<h1 class="font-6x font-100">Welcome</h1>
									<p class="darken font-100 welcome-mess">Enjoy your vacation with us</p>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>


				<div class="row">
					<div class="col-md-12">
						<div class="dark-blue booking-form">
              <form id="checkinform" method="post" action = "search.php" class="row no-padding">
                <input type="hidden" name="sub" value="book" />
								<div class="col-md-2 col-sm-6">
									<label for ="start-date">Arrival Date</label>
      								<i class="fa fa-calendar infield"></i>
      								<input type="text" name="start-date" id="start-date" class="form-control" placeholder="Check In" required />
								</div>
								<div class="col-md-2 col-sm-6">
									<label for ="end-date">Departure Date</label>
      								<i class="fa fa-calendar infield"></i>
      								<input type="text" name="end-date" id="end-date" placeholder="Check Out" required />
								</div>
								<div class = "col-md-2 col-sm-6">
									<label for="numGuests">Guests</label>
     								<i class="fa fa-user infield"></i>
      								<input type="number" name="numGuests" id="numGuests" min="1" max="500" required/>
      							</div>
      							<div class = "col-md-2 col-sm-6">
      								<label for="room-type">Room Type</label>
      								<select id="room-type" name="room-type" required>
      										<!--<option value="all" selected hidden>Room Type</option> -->
									        <option value="all">All</option>
									        <option value="bedroom">Bedroom</option>
									        <option value="ballroom">Ballroom</option>
									        <option value="conferenceroom">Conference</option>
      								</select>
    							</div>
      							
      							<div class = "col-md-2 col-sm-6">
      								  <label for="room-type">Pet Allowability</label>
								      <select id="pet" name="pet">
								      	<!--<option value="all" selected hidden>Allow Pets</option> -->
								        <option value="all">All</option>
								        <option value="Y">Yes</option>
								        <option value="N">No</option>
								      </select> 
      							</div>

      							<div class = "col-md-2 col-sm-6">
      							  <label for="room-type">Smoke Allowability</label>
							      <select id="smoke" name="smoke">
							      	<!--<option value="all" selected hidden>Allow Smoking</option> -->
							        <option value="all">All</option>
							        <option value="Y">Yes</option>
							        <option value="N">No</option>
							      </select>      								
      							</div>

								<div class = "col-md-12 col-sm-6" style="text-align:center;">
									<br>
									<button type="submit" class="button-md green hover-dark-green soft-corners">Search</button>
								</div>
							</form>
						</div>
					</div>
				</div>


  <!-- Contact -->
		<footer class="main-footer">
			<div class="big-footer box darken-less">
				<div class="container">
						<div class="text-dark-blue text-center fancy-heading">
							<h1 class="font-700">Contact</h1>
							<hr class="text-dark-blue size-30 center-me">
						</div>
							<ul class="clean-list contact-info text-dark-blue uppercase">
								<center><li></i> <b>Address: </b> 304 Hotel Street, Vancouver BC, HOHOHO</li>
								<li><b>E-mail: </b> <a href="mailto:hotelia@gmail.com">304@hotel.com</a></li>
								<li></i> <b>Phone: </b> (604) 822 1234</li>
							</center>
							</ul>
				</div>
			</div>
		</footer>
	</div>



</body>
</html>