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
$customer_id=$_SESSION['customer_id'];

$query = "SELECT * from bookings JOIN room ON room.roomID = bookings.room_id JOIN customer ON customer.customerID = bookings.customer_id WHERE customer_id='$customer_id' ORDER BY booking_id DESC;";

$result = mysqli_query($DBC, $query);

// Check if there are any rows in the result
if (mysqli_num_rows($result) > 0) {
    $bookings = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $bookings = []; // Empty array if no bookings found
}

// Close the database connection
mysqli_close($DBC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - List Bookings</title>
</head>

<body>
<?php 
    include "logout_button.php";
?>
    <h1>Customer Dashboard - List Bookings</h1>
    <a href="add_booking.php">Add new booking</a>
    <table border="1">
        <tr>
            <th>Booking Info</th>
            <th>Customer Name</th>
            <th>Action</th>
        </tr>

        <?php foreach ($bookings as $booking): ?>
            <tr>
                <td>
                    <?php echo "<b>".$booking['roomname'] ."</b> (". $booking['roomID'].") ".$booking['check_in_date'] . " to  " .$booking['check_out_date']; ?>
                    </td>
                    <td>
                    <?php echo $booking['firstname']; ?>
                </td>
                <td>
                    
                <a href="customerreview.php?id=<?php echo $booking['booking_id']; ?>">Review</a>

                    <a href="preview.php?id=<?php echo $booking['booking_id']; ?>">Preview</a>
                    <a href="editbooking.php?id=<?php echo $booking['booking_id']; ?>">Edit</a>
                    <a href="deletebooking.php?id=<?php echo $booking['booking_id']; ?>">Delete</a>
                </td>
                </tr>
        <?php endforeach; ?>

    </table>

</body>

</html>