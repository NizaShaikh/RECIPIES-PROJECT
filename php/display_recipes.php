<?php
include 'db_connect.php';

$sql = "SELECT * FROM recipes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<h2>" . htmlspecialchars($row["title"]) . "</h2>";
        echo "<p>" . htmlspecialchars($row["description"]) . "</p>";
        echo "<p><strong>Ingredients:</strong> " . htmlspecialchars($row["ingredients"]) . "</p>";
        echo "<p><strong>Instructions:</strong> " . htmlspecialchars($row["instructions"]) . "</p>";
        // Fetch and display reviews for this recipe here
    }
} else {
    echo "No recipes found.";
}

$conn->close();

