<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "recipe_db"; // Change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total users
$userQuery = "SELECT COUNT(*) AS total_users FROM users";
$userResult = $conn->query($userQuery);
$totalUsers = $userResult->fetch_assoc()['total_users'] ?? 0;

// Fetch total ratings
$ratingQuery = "SELECT COUNT(*) AS total_ratings FROM ratings";
$ratingResult = $conn->query($ratingQuery);
$totalRatings = $ratingResult->fetch_assoc()['total_ratings'] ?? 0;

$response = [
    'total_users' => $totalUsers,
    'total_ratings' => $totalRatings,
];

// Send data as JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
