<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bnb";


//customer login ids
// $username = "customer@gmail.com"; 
// $password = "password"; 


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare SQL query
    $sql = "SELECT * FROM customer WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // If the query returns a row, the email and password match
        $row = $result->fetch_assoc();
        $id = $row['customerID'];
        $_SESSION["customer_email"] = $email; //
        $_SESSION["customer_id"] = $id; //
        header("Location: customer/dashboard.php");       
        exit();
    } else {
        // No match found
        echo "Invalid email or password";
    }

} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>