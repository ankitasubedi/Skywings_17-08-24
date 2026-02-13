<?php
// booking.php

// Include the database connection file
include 'db_connect.php';

// Start the session
session_start();

// Get the POST data from the form
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$destination = $_POST['destination'];
$date = $_POST['date'];
$transportation = isset($_POST['transportation']) ? implode(", ", $_POST['transportation']) : '';
$message = $_POST['message'];

// Prepare and execute the SQL query
$stmt = $conn->prepare("INSERT INTO bookings (name, email, phone, destination, date, transportation, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $name, $email, $phone, $destination, $date, $transportation, $message);

if ($stmt->execute()) {
    // Booking successful
    $_SESSION['booking_success'] = "Booking successful! We will contact you soon.";
    header('Location: booking.html');
} else {
    // Booking failed
    $_SESSION['booking_error'] = "Booking failed. Please try again.";
    header('Location: booking.html');
}

$stmt->close();
$conn->close();
?>
