<?php
include('../config.php');
session_start();

$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit;
}
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a form field for the review content and booking_id
    $review_content = $_POST['review_content'];
    $booking_id = $_GET['id'];
    // $booking_id = $_POST['booking_id'];

    // Perform a simple validation if needed

    // Insert the review into the database
    $sql = "UPDATE bookings SET review = '$review_content' WHERE booking_id = $booking_id";


    if ($DBC->query($sql) === TRUE) {
        echo "Review inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Form</title>
</head>
<body>
<h1>Customer Review</h1>
<h2>
     <a href='dashboard.php'>[Return to Booking listing]</a>
        <a href="dashboard.php">[Return to main page]</a>
    </h2>
<form action="" method="post">
    

    <label for="review_content">Review:</label><br>
    <textarea id="review_content" name="review_content" rows="4" cols="50" required></textarea><br><br>  

    <input type="submit" value="Submit Review">
</form>

</body>
</html>