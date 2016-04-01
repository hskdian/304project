
var dateToday = new Date();

$(function() {
 $("#start-date").datepicker({
      minDate: dateToday,
      dateFormat: "dd-M-yy",
  
      onSelect: function(){
          var enddate = $('#end-date');
          var startdate = $(this).datepicker('getDate');
          console.log("Start Date: " + startdate);

          //set Departure's minDate = Arrival Date + 1
          startdate.setDate(startdate.getDate() + 1);
          console.log("Departure's Min: " + startdate);
          enddate.datepicker("option", "minDate", startdate);
        }
    });

 $("#end-date").datepicker({
      dateFormat: "dd-M-yy",
      minDate: dateToday,
  });
});

$(document).ready(function() {
  $('#checkinform').submit(function(event) {
  event.preventDefault();
  if ($('#checkinform')[0].checkValidity()) {

    var startDate = $('#start-date').val();
    var endDate = $('#end-date').val();

    // Number of Guests
    var numGuests = $('#numGuests').val();
    // Room type
    var roomType = $('#room-type').val();
    // Pet
    var petAllow = $('#pet').val();
    // Smoke
    var smokeAllow = $('#smoke').val();

    //Checking values submitted
    console.log("Arrival Date: "+ startDate);
    console.log("Departure Date: " + endDate);
    console.log("Guest No: " + numGuests);
    console.log("Room Type: " + roomType);
    console.log("Pet: " + petAllow);
    console.log("Smoke: " + smokeAllow);

    var target = "search.php?sub=book&start-date="+ startDate + 
    "&end-date=" + endDate +
    "&numGuests=" + numGuests + 
    "&room-type=" + roomType + 
    "&pet=" + petAllow + 
    "&smoke=" + smokeAllow;

    console.log(target);
    window.open(target, '_blank');

  }
});
});


$(document).ready(function() {
  $('.popup-with-form').magnificPopup({
    type: 'inline',
    preloader: false,
    focus: '#employeeid',

    callbacks: {
      beforeOpen: function() {
        if($(window).width() < 700) {
          this.st.focus = false;
        } else {
          this.st.focus = '#employeeid';
        }
      }
    }
  });
});


$(document).ready(function() {
  $('#employeelogin').submit(function(event) {
      event.preventDefault();

      var empID = $('#empID').val();
      var empPW = document.getElementById('empPW').value;

      console.log(empID);
      console.log(empPW);


      if (empID == 'admin304') {
        if (empPW == '304'){
          location="employee.php";
        } else {
          document.forms["employeelogin"].reset();
          alert ("INTRUDER ALERT! Invalid Password!");
        }
      } else {
          document.forms["employeelogin"].reset();
          alert ("INTRUDER ALERT! Invalid Employee ID!");
      }
    
  });
});