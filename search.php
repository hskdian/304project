<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
  <meta charset="UTF-8">
  <title>304 Hotel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font-->
  <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' >

  <!-- Stylesheets -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" media="all" href="css/template.css" >
  <link rel="stylesheet" type="text/css" media="all" href="css/magnific-popup.css" >
  <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
  <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">


<!-- Javscripts -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script type="text/javascript" src="js/jquery.magnific-popup.js"></script>
  <script type="text/javascript" src="js/scripts.js"></script>
  <script type="text/javascript" src="http://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>


  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js"></script>




</head>



<body>

<!-- Top Header / Header Bar -->
<div id="home" class="boxed-view">
<?php include("header.html");?>



        <!-- main content -->
        <section class="box">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="text-dark-blue text-center fancy-heading">
							<h1 class="font-700">Rooms Available</h1>
							<br>			
						</div>
					</div>
				</div> <!-- /.row -->



<?php

$startDate = $_GET['start-date'];
$endDate = $_GET['end-date'];
$numGuests = $_GET['numGuests'];
$roomType = $_GET['room-type'];
$petAllow = $_GET['pet'];
$smokeAllow = $_GET['smoke'];


echo "Check-In: " . $startDate . "<br>";
echo "Check-Out: " . $endDate . "<br>";
echo "Guests Number: " . $numGuests . "<br>";
echo "Room Type: " . $roomType . "<br>";

if (strcmp($petAllow, 'all') == 0) {
	$petAllow = '%';
}

if (strcmp($smokeAllow, 'all') == 0) {
	$smokeAllow = '%';
}

if (strcmp($roomType, 'all') == 0) {
	$roomType = '%';
}

// Connect to Oracle db
if ($conn = oci_connect("ora_n9b9", "a40798126", "ug")){
	echo "<script>console.log( 'Successfully connected to Oracle.')</script>";
}
if (!$conn) {
	$err = OCIError();
	trigger_error(htmlentities($err['message']), E_USER_ERROR);
}

// Prepare the statement

$query1 = "SELECT DISTINCT
room.floorno as X,  bedroom.roomno as Room, room.floorno as Floor,  bedroom.bedroom_type_name as Type, room.pet as Pet, 
room.smoking as smoking, room.capacity as Capacity,
 bedroomtype.nightlyprice as price, 
bedroomtype.numofbath as numBaths, bedroomtype.kitchen as kitchen, 
containsbed.numofbeds as numBeds, containsbed.bedname as bedname, room.roomno as Reserve
FROM bedroom
      INNER JOIN containsbed
            ON containsbed.bedroom_type_name = bedroom.bedroom_type_name
      INNER JOIN bedroomtype
            ON bedroomtype.bedroom_type_name = containsbed.bedroom_type_name
      INNER JOIN room
            ON room.roomno = bedroom.roomno
WHERE bedroom.roomno IN  
      (SELECT roomno 
      FROM room
      WHERE room.availability ='Y' AND
      room.pet LIKE '${petAllow}' AND
	  room.smoking LIKE '${smokeAllow}' AND
	  room.type = 'bedroom' AND
	  room.capacity >= '${numGuests}')
ORDER BY bedroom.roomno";


$query2 = "SELECT DISTINCT
room.roomno, room.floorno, 
room.pet, room.smoking, room.capacity, 
ballroom.hourlyprice, ballroom.roomno as X
FROM room
      INNER JOIN ballroom
            ON ballroom.roomno = room.roomno
WHERE room.availability = 'Y' AND
room.pet LIKE '${petAllow}' AND
room.smoking LIKE '${smokeAllow}' AND
room.capacity >= '${numGuests}' AND
room.type = 'ballroom'";


$query3 = "SELECT DISTINCT
room.roomno,room.floorno, 
room.pet, room.smoking, room.capacity, 
conferenceroom.hourlyprice, conferenceroom.roomno as X
FROM room
      INNER JOIN conferenceroom
            ON conferenceroom.roomno = room.roomno
WHERE room.availability = 'Y' AND
room.pet LIKE '${petAllow}' AND
room.smoking LIKE '${smokeAllow}' AND
room.capacity >= '${numGuests}' AND
room.type = 'conferenceroom'";




if (strcmp($roomType, '%') == 0){
		$stid1 = oci_parse($conn, $query1);
		$stid2 = oci_parse($conn, $query2);
		$stid3 = oci_parse($conn, $query3);
		$r1 = oci_execute($stid1);
		$r2 = oci_execute($stid2);
		$r3 = oci_execute($stid3);


		print "<table id='allresults1' class='display' cellspacing='0' max-width='100%'>\n";
		print "<thead>\n";
		print "<tr>\n";

	 /*	$ncols1 = oci_num_fields($stid1);

		for ($i = 1; $i <= $ncols1; $i++) {
    		$column_name  = oci_field_name($stid1, $i);
    		print "<th>";
        echo $column_name;
    		print "</th>";
		} 
    */

    print "<th></th>
            <th>Room</th>
            <th>Floor</th>
            <th>Bedroom Type</th>
            <th>Allows Pets</th>
            <th>Allows Smoking</th>
            <th>Capacity</th>
            <th>Nightly Price</th>
            <th>baths</th>
            <th>kitchen</th>
            <th>beds</th>
            <th>bedname</th>
            <th>Reserve</th>";


		print "</tr>\n";
		print "<tbody>";

		while ($row = oci_fetch_array($stid1, OCI_ASSOC+OCI_RETURN_NULLS)) {
   			print "<tr>\n";
   			foreach ($row as $item) {
        		print "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    		}
    	print "</tr>\n";
		}
		print "</tbody>";
		print "</table>\n";




		print "<table id='allresults2' class='display' cellspacing='0'>\n";
		print "<thead>\n";
		print "<tr>\n";

	 /*	$ncols2 = oci_num_fields($stid2);

		  for ($i = 1; $i <= $ncols2; $i++) {
      		$column_name  = oci_field_name($stid2, $i);
      		print "<th>";
      		echo $column_name;
      		print "</th>";
		  }
    */

        print "<th>Room</th>
              <th>Floor</th>
              <th>Allows Pets</th>
              <th>Allows Smoking</th>
              <th>Capacity</th>
              <th>Hourly Price</th>
              <th>Reserve</th>";


		print "</tr>\n";
		print "<tbody>";

		while ($row = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS)) {
   			print "<tr>\n";
   			foreach ($row as $item) {
        		print "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    		}
    	print "</tr>\n";
		}
		print "</tbody>";
		print "</table>\n";



    print "<table id='allresults3' class='display' cellspacing='0'>\n";
    print "<thead>\n";
    print "<tr>\n";

    print "<th>Room</th>
              <th>Floor</th>
              <th>Allows Pets</th>
              <th>Allows Smoking</th>
              <th>Capacity</th>
              <th>Hourly Price</th>
              <th>Reserve</th>";


    print "</tr>\n";
    print "<tbody>";

		while ($row = oci_fetch_array($stid3, OCI_ASSOC+OCI_RETURN_NULLS)) {
   			print "<tr>\n";
   			foreach ($row as $item) {
        		print "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    		}
    	print "</tr>\n";
		}
    print "</tbody>";
    print "</table>\n";


} else 

	if (strcmp($roomType, 'bedroom') == 0){
		$query = $query1;
    $stid4 = oci_parse($conn, $query);
    $r2 = oci_execute($stid4);

    print "<table id='allresults1' class='display' cellspacing='0' max-width='100%'>\n";
    print "<thead>\n";
    print "<tr>\n";


    print "<th></th>
            <th>Room</th>
            <th>Floor</th>
            <th>Bedroom Type</th>
            <th>Allows Pets</th>
            <th>Allows Smoking</th>
            <th>Capacity</th>
            <th>Nightly Price</th>
            <th>baths</th>
            <th>kitchen</th>
            <th>beds</th>
            <th>bedname</th>
            <th>Reserve</th>";


    print "</tr>\n";
    print "<tbody>";

    while ($row = oci_fetch_array($stid4, OCI_ASSOC+OCI_RETURN_NULLS)) {
        print "<tr>\n";
        foreach ($row as $item) {
            print "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
        }
      print "</tr>\n";
    }
    print "</tbody>";
    print "</table>\n";    


	} else {

	if (strcmp($roomType, 'ballroom') == 0){
		$query = $query2;
	}

	if (strcmp($roomType, 'conferenceroom') == 0){
		$query = $query3;
	}

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

  print "<table id='indivResults' class='display' cellspacing='0'>\n";
  print "<thead>\n";
  print "<tr>\n";

  print "<th>Room</th>
              <th>Floor</th>
              <th>Allows Pets</th>
              <th>Allows Smoking</th>
              <th>Capacity</th>
              <th>Hourly Price</th>
              <th>Reserve</th>";

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

}


oci_free_statement($stid);
oci_close($conn);


?>




<script>
	

  $(function(){
    var table = $('#allresults1').DataTable({
		"columnDefs": [ {
      "targets": -1,
      "data": null,
      "defaultContent": "<button>Book Now</button>"
    },
    {
      "targets": [8, 9, 10, 11],
      "visible": false
    },
    {
      "targets": 0,
      "className": 'details-control',
      "orderable": false,
      "data": null,
      "defaultContent": ''
    }
    ]

	});


	$('#allresults1').on( 'click', 'button', function () {
        var data = table.row( $(this).closest("tr") ).data();
		    var col = $(this).closest("td").index();

		    var target = "reservation.php?sub=book&start-date="+ "<?php echo $startDate; ?>" + 
    					"&end-date=" + "<?php echo $endDate; ?>" +
    					"&room-no=" + data[1];

    	 console.log(target);
    	// window.open(target, '_blank');

    } );


    $('#allresults1 tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data())).show();
            tr.addClass('shown');
        }
    } );


    var table1 = $('#allresults2').DataTable({
    "columnDefs": [ {
      "targets": -1,
      "data": null,
      "defaultContent": "<button>Book Now</button>"
    }]

  });

    $('#allresults2').on( 'click', 'button', function () {
        var data = table1.row( $(this).parents('tr') ).data();
        var col = $(this).closest("td").index();

        var target = "reservation.php?sub=book&start-date="+ "<?php echo $startDate; ?>" + 
              "&end-date=" + "<?php echo $endDate; ?>" +
              "&room-no=" + data[0];

       console.log(target);
      // window.open(target, '_blank');

    });

    var table2 = $('#allresults3').DataTable({
    "columnDefs": [ {
      "targets": -1,
      "data": null,
      "defaultContent": "<button>Book Now</button>"
    }]

  });

    $('#allresults3').on( 'click', 'button', function () {
        var data = table2.row( $(this).parents('tr') ).data();
        var col = $(this).closest("td").index();

        var target = "reservation.php?sub=book&start-date="+ "<?php echo $startDate; ?>" + 
              "&end-date=" + "<?php echo $endDate; ?>" +
              "&room-no=" + data[0];

       console.log(target);
      // window.open(target, '_blank');

    });



  });
	

function format ( d ) {


    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Bed Type:</td>'+
            '<td>'+d[11]+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Number of Beds:</td>'+
            '<td>'+d[10]+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Number of Bathrooms:</td>'+
            '<td>'+d[8]+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Has a Kitchen?:</td>'+
            '<td>'+d[9]+'</td>'+
        '</tr>'+
    '</table>';
}
 
  $(function(){

    var table = $('#indivResults').DataTable({
        "columnDefs": [ {
          "targets": -1,
          "data": null,
          "defaultContent": "<button>Book Now</button>"
        }]

      });

        $('#indivResults').on( 'click', 'button', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var col = $(this).closest("td").index();

            var target = "reservation.php?sub=book&start-date="+ "<?php echo $startDate; ?>" + 
                  "&end-date=" + "<?php echo $endDate; ?>" +
                  "&room-no=" + data[0];

           console.log(target);
          // window.open(target, '_blank');

        });



  });

  </script>






</html>