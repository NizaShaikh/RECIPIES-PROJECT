<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to submit a recipe or review!";
} else {
    // Allow submission
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $title = isset($_POST['title']) ? $conn->real_escape_string(trim($_POST['title'])) : '';
    $description = isset($_POST['description']) ? $conn->real_escape_string(trim($_POST['description'])) : '';
    $ingredients = isset($_POST['ingredients']) ? $conn->real_escape_string(trim($_POST['ingredients'])) : '';
    $instructions = isset($_POST['instructions']) ? $conn->real_escape_string(trim($_POST['instructions'])) : '';

    // Check if all required fields are filled
    if (!empty($title) && !empty($description) && !empty($ingredients) && !empty($instructions)) {
        // Prepare and execute the SQL query
        $sql = "INSERT INTO recipes (title, description, ingredients, instructions) VALUES ('$title', '$description', '$ingredients', '$instructions')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Recipe submitted successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Please fill in all fields.";
    }
}

$conn->close();

