<?php
// login.php

// Include the database connection file
include 'db_connect.php';

// Start the session
session_start();

// Get the POST data from the form
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare and execute the SQL query
$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    
    // Verify the password
    if (password_verify($password, $hashedPassword)) {
        // Credentials are valid, redirect to index.html
        header('Location: index.html');
        exit();
    } else {
        // Invalid password
        header('Location: login.html?error=1');
        exit();
    }
} else {
    // Invalid username
    header('Location: login.html?error=1');
    exit();
}

$stmt->close();
$conn->close();
?>
