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

mysqli_close($DBC);
?>

<!DOCTYPE html>
 <html>
    <head>
        <title>

        </title>
    </head>
    <meta charset="utf-8"> <meta name="viewport" content="width=device-width, initial-scale=1">
    <body>
    <?php 
    include "logout_button.php";
?>
        <h1>Booking preview before deletion</h1>
        <h2>
            <a href='dashboard.php'>[Return to Booking listing]</a>
            <a href="dashboard.php">[Return to main page]</a>

        </h2>
    <form method="post" action="delete_booking.php">
        <fieldset>
            <p><?php echo
                    "<b> Room name:</b> " . $booking['roomname'] . " <br> <b>Check-In-date:</b> " . $booking['check_in_date'] . " <br><b>Check-Out-date:</b> " . $booking['check_out_date'] . " <br>
                <b>mobile number:</b> " . $booking['phone_no'] . " <br><b>Booking Extras:</b> " . $booking['extra'] . " <br><b>Booking reviews</b> " . $booking['review'] . "<br>"
                    ?>
            </p>
        </fieldset>
        <h1>Are you sure you want to Delete this booking</h1>
        <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
        <input type="submit" name="delete" value="Delete">
        <input type="button" value="Cancel" onclick="window.location.href='dashboard.php'">

    </form>
    </body>
 </html>