<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db_connect.php'; // Ensure this file is correctly included

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username  = 'niza';
    $password = 'niza123';
  
    // Debugging output
    echo "Username: $username<br>";
    echo "Password: $password<br>";

    // Query to check if the user exists in the database
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        // Query error
        echo "Database query failed: " . $conn->error;
    }

    if ($result->num_rows == 1) {
        // Successful login
        $_SESSION['user_id'] = $username; // Store user information in session
        echo "LOGGED IN!";
        header("Location: ../index.html"); // Redirect to index.html after login
        exit();
    } else {
        // Invalid login credentials
        echo "Invalid login credentials!";
    }
}
