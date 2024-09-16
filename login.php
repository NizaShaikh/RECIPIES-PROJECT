<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db_connect.php'; // Ensure database connection is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Print received credentials for debugging
    echo "Username: $username<br>";
    echo "Password: $password<br>";

    // Query to check if the user exists in the database
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        // Query error
        echo "Database query failed: " . mysqli_error($conn);
    }

    if (mysqli_num_rows($result) == 1) {
        // Successful login
        $_SESSION['user_id'] = $username; // Store user information in session
        header("Location: ../index.html"); // Redirect to index.html after login
        exit();
    } else {
        // Invalid login credentials
        echo "Invalid login credentials!";
    }
}
?>
