<?php
include('../config.php');
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['customer_email'])) {
    header("Location: ../customer_login.php");
    exit();
}

// Include necessary files for database connection, if any

// Connect to the database
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit;
}

$query = "SELECT * from bookings";

$result = mysqli_query($DBC, $query);

// Check if there are any rows in the result

if (mysqli_num_rows($result) > 0) {
    $bookings = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
} else {
    $bookings = []; // Empty array if no bookings found
}
$room_ids=[];
foreach($bookings as $book){
    array_push($room_ids,$book['room_id']);
}

$query2 = "SELECT * from room";
$result2 = mysqli_query($DBC, $query2);
// Check if there are any rows in the result
if (mysqli_num_rows($result2) > 0) {
    $room_list = mysqli_fetch_all($result2, MYSQLI_ASSOC);    
} else {
    $room_list = []; // Empty array if no bookings found
}
// booked rooms
$available_rooms=[];
foreach($room_list as $room){
    // if(!in_array($room['roomID'],$room_ids)){   
        array_push($available_rooms,$room);
    // }
}
// Close the database connection
mysqli_close($DBC);
?>
<!DOCTYPE html>
 <html>
    <head>
        <title>

        </title>
    </head>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Datepicker - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
 $(document).ready(function() {
$.datepicker.setDefaults({
dateFormat: 'yy-mm-dd'
});
$(function() {
da = $("#check_in_date").datepicker()
leave = $("#check_out_date").datepicker()
datepic = $("#datepic").datepicker()
dateout = $("#dateout").datepicker()
});
});
  </script>
  <script>
   function add_booking(){
    let room_id=$('#room_id').val();   
            let booking_extras=$('#booking_extras').val();
            let check_in_date=$('#check_in_date').val();
            let check_out_date=$('#check_out_date').val();
            let phone_no=$('#phone_no').val();

            if(!room_id){
                alert('Please select room');
                return;
            }else if(!check_in_date){
                alert('Please select check in date');
                return;
            }else if(!check_out_date){
                alert('Please select check out date');
                return;
            }else if(!phone_no){
                alert('Please enter phone no.');
                return;
            }
            $.ajax({
                url:"/yashams/customer/api/v1/bookings/new.php",
                method:'POST',
                data:{
                    roomID: room_id,
                    checkin:check_in_date,
                    checkout: check_out_date,
                    phoneNo:phone_no,
                    extra:booking_extras
                },
                success:function(response){
                    let data=JSON.parse(response)
                    if(data.status=='1'){
                        alert(data.message);
                        window.location.assign('dashboard.php')
                    }else {
                        alert(data.message);
                        return;
                    }
                }
            })
   }
    </script>
    <body>
        <h1>Make a booking</h1>
        <h2>
            <a href='dashboard.php'>[Return to Booking listing]</a>
            <a href="dashboard.php">[Return to main page]</a>
        </h2>
        <h3>Booking for test</h3>
        <form>
            <label for="room">Room(name,type,beds)</label>
            <select id="room_id">
                <option value="">Select</option>
                <?php 
                    foreach($available_rooms as $room){
                ?>
                <option value="<?php echo $room['roomID']; ?>"><?php echo $room['roomname']; ?></option>
                <?php 
                    }
                ?>                
            </select> 
            <p>  
                <label for="da">Check In Date:</label>
                <input type="text" id="check_in_date" name="da" required>
            </p>
            <p>
                <label for="leave">Check Out Date:</label>
                 <input type="text" id="check_out_date" name="leave" required>
            </p>
            <p>
                <label for="">Phone Number</label>
                <input type="tel" placeholder="(64)123 1234" id="phone_no">
            </p>
            <p>
                <label for="booking Extras"> Booking Extras:</label>
                <textarea id="booking_extras" name="Booking Extras"  rows="5" required></textarea>
            </p>
            <p>
                <input type="button" value="ADD" onclick="add_booking()">   
            </p>
                <hr>
                <h2>search for room Availability</h2>

                <label for="datepic">Check In Date:</label>
                <input type="text" id="datepic" name="datepic" required>

                <label for="dateout">Check Out Date:</label>
                <input type="text" id="dateout" name="dateout" required>

                <input type="button" value="search Availability" onclick="searchforavaialb()"><br><br>                
                <div id="roomavailabel">
                <table border="1">
                    <thead>
                    <tr>
                        <th>Room</th> 
                        <th>Room Name</th>
                        <th>Room Type</th> 
                        <th>Beds</th>
                    </tr>
                    </thead>
                    <tbody id="room_list">

                    </tbody>                        
                </table>        
        </form>

    </body>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <script>
        function searchforavaialb(){
            let check_in_date=$('#datepic').val();
            let check_out_date=$('#dateout').val();
            $.ajax({
                url:"/yashams/customer/api/v1/bookings/roomcheck.php",
                method:'POST',
                data:{
                    checkin:check_in_date,
                    checkout: check_out_date,
                },
                success:function(response){
                    let data=JSON.parse(response)
                     let htmldata='';
                     for(let item of data.data){
                        htmldata+=`
                            <tr>
                                <td>${item.roomID}</td>
                                <td>${item.roomname}</td>
                                <td>${item.roomtype}</td>
                                <td>${item.beds}</td>
                            </tr>
                        `
                     }
                     $('#room_list').html(htmldata)
                }
            })
        }
    </script>
    
 </html>

