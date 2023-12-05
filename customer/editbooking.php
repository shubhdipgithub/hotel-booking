<?php
$booking_id = $_GET['id'];
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



$query = "SELECT *
          FROM bookings
          JOIN room ON room.roomID = bookings.room_id
          JOIN customer ON customer.customerID = bookings.customer_id
          WHERE booking_id = ?";

$stmt = mysqli_prepare($DBC, $query);
mysqli_stmt_bind_param($stmt, "i", $booking_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die('Error: ' . mysqli_error($DBC));
}

$booking = mysqli_fetch_assoc($result);


?>

<!DOCTYPE html>
<html>

<head>
    <title>Update Booking</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(document).ready(function () {
            $.datepicker.setDefaults({
                dateFormat: 'yy-mm-dd'
            });
            $(function () {
                da = $("#da").datepicker()
                leave = $("#leave").datepicker()
            });
        });
    </script>
    <script>
   function edit_booking(){
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
                url:"/yashams/customer/api/v1/bookings/editnbooking.php",
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
</head>

<body>
<?php 
    include "logout_button.php";
?>
    <h1>Update Booking Details</h1>
    <h2>
        <a href='dashboard.php'>[Return to Booking listing]</a>
        <a href="dashboard.php">[Return to main page]</a>
    </h2>
    <form method="post" action="">
        <fieldset>
            <p>
                <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                <label for="room">Room (name, type, beds):</label>
                <input type="text" id="room_id" name="room"
                    value="<?php echo $booking['roomname'] . ', ' . $booking['roomtype'] . ', ' . $booking['beds']; ?>"
                    readonly>
            </p>

            <p>
                <label for="da">Check In Date:</label>
                <input type="text" id="da" name="checkindate" value="<?php echo $booking['check_in_date']; ?>" required>
            </p>

            <p>
                <label for="leave">Check Out Date:</label>
                <input type="text" id="leave" name="checkOutDate" value="<?php echo $booking['check_out_date']; ?>" required>
            </p>

   

            <p>
                <label for="booking_extras">Booking Extras:</label>
                <textarea id="booking_extras" name="booking_extras" rows="5"
                    required><?php echo $booking['extra']; ?></textarea>
            </p>

            <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">

            <p>
                <input type="submit" value="Update" onclick="edit_booking()">
            </p>
        </fieldset>
    </form>
    <?php
    if($_POST){
        extract($_POST);
        $sql = "UPDATE bookings SET check_in_date = '$checkindate', check_out_date = '$checkOutDate', extra = '$booking_extras' WHERE booking_id = $booking_id";
        $update_result = mysqli_query($DBC,$sql);
        if($update_result){
            header("location:dashboard.php");
        }else{
            echo "something went wrong!";
        }
    }
    mysqli_close($DBC);
    ?>
</body>

</html>