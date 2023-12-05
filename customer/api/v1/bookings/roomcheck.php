<?php
session_start();
// Your database connection logic goes here
// For example:
$dbConnection = new PDO('mysql:host=localhost;dbname=bnb', 'root', '');

// Make a booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/yashams/customer/api/v1/bookings/roomcheck.php') {
    $requestData = json_decode(file_get_contents('php://input'), true);

    // Validate input data
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];

    // Validate date format (assuming 'checkin' and 'checkout' are in 'YYYY-MM-DD' format)
    if (!strtotime($checkin) || !strtotime($checkout)) {
        // http_response_code(400); // Bad Request
        echo json_encode(array("message" => "Invalid date format. Use 'YYYY-MM-DD' format for check-in and check-out dates.","status"=>'0'));
        exit();
    }
    // Check room availability within the specified date range
    $query = $dbConnection->prepare("SELECT room.roomID, room.roomname,room.roomtype,room.beds
    FROM room
    LEFT JOIN bookings ON room.roomID = bookings.room_id
    WHERE bookings.booking_id IS NULL 
       OR (:checkin > bookings.check_out_date OR :checkout < bookings.check_in_date);)
    ");
    $query->bindParam(':checkin', $checkin);
    $query->bindParam(':checkout', $checkout);
    $query->execute();
    $existingBookings = $query->fetchAll(PDO::FETCH_ASSOC);
    if (count($existingBookings) > 0) {
        $arr=[
            "message" => "Avaialble rooms are fetched successfully",
            "status"=>'1',
            "data"=>$existingBookings
        ];
        echo json_encode($arr);
    } else {
        $arr=[
            "message" => "Rooms are not available for this dates",
            "status"=>'0',
            "data"=>[]
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
