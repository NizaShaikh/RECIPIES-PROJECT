<?php
include 'php/db_connect.php'; // Database connection

if (isset($_GET['id'])) {
    $recipeId = intval($_GET['id']);

    $query = "SELECT title, description, ingredients, instructions FROM recipes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $result = $stmt->get_result();
    $recipe = $result->fetch_assoc();

    echo json_encode($recipe);
}
?>
