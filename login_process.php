<?php
session_start(); 

$admin_username = "admin";
$admin_password = "admin123";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];

    if ($input_username === $admin_username && $input_password === $admin_password) {
        // Successful login; set session variables and redirect to admin dashboard
        $_SESSION["admin_username"] = $admin_username; // Set a session variable to identify the admin
        header("Location: admin/dashboard.php");
        exit(); // Make sure to call exit after setting the header to prevent further execution
    } else {
        // Invalid credentials
        echo "Invalid username or password. Please try again.";
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>