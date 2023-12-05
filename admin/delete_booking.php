<?php
include('../config.php');
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
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

 

$booking_id = $_POST["booking_id"];

$delete_query = "DELETE FROM bookings WHERE booking_id = ?";
$stmt = mysqli_prepare($DBC, $delete_query);
mysqli_stmt_bind_param($stmt, "i", $booking_id);
mysqli_stmt_execute($stmt);

mysqli_close($DBC);

// Redirect to the booking listing page after deletion
header("Location:dashboard.php");
exit();

?>