<?php 
include 'db_connect.php'; // Database connection

// $query = "SELECT id, title, image, rating FROM recipes";
// $result = $conn->query($query);
$query = "
SELECT r.id, r.title, r.image, 
    (SELECT AVG(rating) FROM comments WHERE recipe_id = r.id) AS average_rating 
FROM recipes r";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .search-bar {
            width: 100%;
            max-width: 500px;
            margin-left: 430px ;
            padding: 10px;
            border: 1px solid grey;
            border-radius: 5px;
            font-size: 16px;
        }

        .recipe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            grid-gap: 20px;
            padding: 20px;
        }

        .recipe-card {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        .recipe-card img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
    
        }

        .recipe-card h3 {
            margin-top: 10px;
            font-size: 20px;
        }

        .rating {
            color: orange;
            font-size: 18px;
        }

        .recipe-card a {
            display: inline-block;
            margin-top: 10px;           
            text-decoration: none;          
  cursor:pointer;
  padding: 6px;
  border:2px solid chocolate;
  font-size: 17px;
  font-weight: 600;
  background-color: rgb(228, 141, 79);
  color: aliceblue;
}

.recipe-card a:hover{
  background-color: rgb(245, 245, 245);
  color: chocolate;
}
a{
    color: black;
}
a:hover{
    color: red;
}
    </style>
</head>
<body>
    <a href="../index.php">BACK TO HOME</a>
    <h1 style="text-align: center;">Submitted Recipes</h1>
    <!-- Search Bar -->
    <input type="text" id="search" class="search-bar" placeholder="Search for recipes...">

   
    <div class="recipe-grid" id="recipeGrid">
        <?php while($row = $result->fetch_assoc()): ?>
        <div class="recipe-card">
            <img src="../uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
            <h3 class="recipe-title"><?php echo $row['title']; ?></h3>
            <div class="rating">
                <?php 
                $average_rating = round($row['average_rating'], 1); // Round to one decimal
                for($i = 0; $i < floor($average_rating); $i++): ?>
                    ★
                <?php endfor; ?>
                <?php for($i = floor($average_rating); $i < 5; $i++): ?>
                    ☆
                <?php endfor; ?>
                <span>(<?php echo $average_rating; ?> / 5)</span> <!-- Display average rating -->
            </div>
            <a href="recipe_detail.php?id=<?php echo $row['id']; ?>">View Recipe</a>
        </div>
        <?php endwhile; ?>
    </div>


    <script>
        // Search function
        document.getElementById('search').addEventListener('keyup', function() {
            const searchInput = this.value.toLowerCase();
            console.log("Search Input: ", searchInput); // Check if search is being captured
            const recipes = Array.from(document.querySelectorAll('.recipe-card')); // All recipe cards

            recipes.forEach(function(recipe) {
                const title = recipe.querySelector('.recipe-title').textContent.toLowerCase();
                console.log("Title: ", title); // See if titles are retrieved correctly

                if (title.includes(searchInput)) {
                    recipe.style.display = "block"; // Show matching recipe
                } else {
                    recipe.style.display = "none";  // Hide non-matching recipe
                }
            });
        });
    </script>
</body>
</html>
