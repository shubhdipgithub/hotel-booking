<?php
session_start();
// Your database connection logic goes here
// For example:
$dbConnection = new PDO('mysql:host=localhost;dbname=bnb', 'root', '');

// Make a booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/yashams/customer/api/v1/bookings/new.php') {
    $requestData = json_decode(file_get_contents('php://input'), true);

    // Validate input data
    $customerID = $_SESSION['customer_id'];
    $roomID = $_POST['roomID'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $phoneNo = $_POST['phoneNo'];
    $extra = $_POST['extra'];

    // Validate date format (assuming 'checkin' and 'checkout' are in 'YYYY-MM-DD' format)
    if (!strtotime($checkin) || !strtotime($checkout)) {
        // http_response_code(400); // Bad Request
        echo json_encode(array("message" => "Invalid date format. Use 'YYYY-MM-DD' format for check-in and check-out dates.","status"=>'0'));
        exit();
    }

    // Check room availability within the specified date range
    $query = $dbConnection->prepare("SELECT * FROM bookings WHERE room_id = :roomID AND
                                     NOT (:checkin > bookings.check_out_date OR :checkout < bookings.check_in_date)");
    $query->bindParam(':roomID', $roomID);
    $query->bindParam(':checkin', $checkin);
    $query->bindParam(':checkout', $checkout);
    // $query->bindParam(':phoneno', $phoneNo);
    // $query->bindParam(':extra', $extra);
    $query->execute();
    $existingBookings = $query->fetchAll(PDO::FETCH_ASSOC);

    if (count($existingBookings) > 0) {
        // http_response_code(409); // Conflict
        echo json_encode(
            array("message" => "Room not available for the specified dates.","status"=>"2")
        );
    } else {
        // Proceed with the booking insertion into the database
        $insertQuery = $dbConnection->prepare("INSERT INTO bookings (customer_id, room_id, check_in_date, check_out_date,phone_no, extra) 
                                               VALUES (:customerID, :roomID, :checkin, :checkout, :phoneno,:extra)");
        $insertQuery->bindParam(':customerID', $customerID);
        $insertQuery->bindParam(':roomID', $roomID);
        $insertQuery->bindParam(':checkin', $checkin);
        $insertQuery->bindParam(':checkout', $checkout);
        $insertQuery->bindParam(':phoneno', $phoneNo);
        $insertQuery->bindParam(':extra', $extra);
        $insertQuery->execute();

        // Return success message
        // http_response_code(201); // Created
        $arr=[
            "message" => "Booking created successfully",
            "status"=>'1'
        ];
        echo json_encode($arr);
    }
}

// Handle other endpoints or invalid requests
else {
    // http_response_code(404); // Not Found
    echo json_encode(array("message" => "Invalid request","status"=>'0'));
}
?>
