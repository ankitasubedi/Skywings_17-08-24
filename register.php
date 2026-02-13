<?php
// register.php

// Include the database connection file
include 'db_connect.php';

// Start the session
session_start();

// Get the POST data from the form
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare and execute the SQL query
$stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, username, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $firstname, $lastname, $email, $email, $hashedPassword);

if ($stmt->execute()) {
    // Registration successful
    $_SESSION['register_success'] = "Registration successful!";
    header('Location: login.html');
} else {
    // Registration failed
    $_SESSION['register_error'] = "Registration failed. Please try again.";
    header('Location: login.html');
}

$stmt->close();
$conn->close();
?>
