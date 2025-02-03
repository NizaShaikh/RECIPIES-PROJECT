<?php
include 'db_connect.php'; // Your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $instructions = mysqli_real_escape_string($conn, $_POST['instructions']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $image = $_FILES['image']['name'];
    $upload_dir = '../uploads/';
    $target_file = $upload_dir . basename($image);

    // Move uploaded image to the target directory
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    // Process YouTube URL
    $youtube_url = mysqli_real_escape_string($conn, $_POST['video_url']);
    $embed_url = str_replace("watch?v=", "embed/", $youtube_url);

    // Insert into database
    $sql = "INSERT INTO recipes (title, description, ingredients, instructions, category, image, video_url) 
            VALUES ('$title', '$description', '$ingredients', '$instructions', '$category', '$image', '$embed_url')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: display_recipes.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
