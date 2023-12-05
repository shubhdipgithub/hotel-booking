<?php
include('config.php');
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


$query = "SELECT * from bookings JOIN room ON room.roomID = bookings.room_id JOIN customer ON customer.customerID = bookings.customer_id ORDER BY booking_id DESC;";

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
 <html>
    <head>
        <title>

        </title>
    </head>
    <meta charset="utf-8"> <meta name="viewport" content="width=device-width, initial-scale=1">
    <body>

        <h1>Add room review</h1>
        <h2>
            <a href='bookings.php'>[Return to Booking listing]</a>
            <a href="index.php">[Return to main page]</a>
        </h2>
        <h2>Review made by test</h2>
        <label for="reviews">reviews</label>
        <textarea id="Review" name="Review" rows="4" required></textarea>
        <p>
        <input type="button" value="updated">
    </p>
    </body>
 </html>