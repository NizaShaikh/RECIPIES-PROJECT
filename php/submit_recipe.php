<?php
include 'db_connect.php'; // Include your database connection file
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "<div class='alert'>
            <h2 style='color: black; text-align: center;'>You must be logged in to submit a recipe.</p>
            <h3 style='text-align: center;'>Please <a href='login.php'>LOG IN</a> or <a href='signup.php'>SIGN UP</a>.</p>
            <h4 style='color:black; margin-left:20px; margin-top:-90px;'><a href='../index.php'>BACK TO HOME</a></h4>
            </div>";
   

    exit(); // Stop the execution if not logged in
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the image file has been uploaded
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "../uploads/";
        $imageName = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $imageName;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Ensure it's an actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Upload the file to the server
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Prepare and bind the SQL statement
                $stmt = $conn->prepare("INSERT INTO recipes (title, description, ingredients, instructions, category, image) VALUES (?, ?, ?, ?, ?, ?)");

                // Bind parameters to the SQL statement (s = string type)
                $stmt->bind_param("ssssss", $title, $description, $ingredients, $instructions, $category, $image);

                // Set variables and execute the statement
                $title = $_POST["title"];
                $description = $_POST["description"];
                $ingredients = $_POST["ingredients"];
                $instructions = $_POST["instructions"];
                $category = $_POST["category"];
                $image = $imageName;  // Store only the image name in the database

                // Execute the prepared statement
                if ($stmt->execute()) {
                    echo "Recipe submitted successfully!";
                    // Redirect to the display page (if needed)
                    header("Location: display_recipes.php");
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }

                // Close the prepared statement
                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your image.";
            }
        } else {
            echo "File is not an image.";
        }
    }
}

$conn->close();

