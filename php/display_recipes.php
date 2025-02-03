<?php 
include 'db_connect.php'; // Database connection

// Query to fetch recipes grouped by category
$query = "SELECT r.id, r.title, r.image, r.category, 
          (SELECT AVG(rating) FROM comments WHERE recipe_id = r.id) AS average_rating 
          FROM recipes r";
$result = $conn->query($query);

// Check if the query executed successfully
if (!$result) {
    die("Error executing query: " . $conn->error);
}

// Initialize arrays for categories
$recipes_by_category = [
    'Starters' => [],
    'Drinks' => [],
    'Main Course' => [],
    'Desserts' => []
];

// Populate recipes by category
while ($row = $result->fetch_assoc()) {
    if (isset($recipes_by_category[$row['category']])) {
        $recipes_by_category[$row['category']][] = $row;
    } else {
        // Handle any unexpected categories
        $recipes_by_category[$row['category']] = [$row];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Recipes</title>
    <link rel="stylesheet" href="style.css">
    <style>

.dark-mode {
  background-color: #121212; /* Dark background */
  color: #ffffff; /* Light text */
}

.dark-mode nav,
.dark-mode header,
.dark-mode footer {
  background-color: #1e1e1e; /* Dark header/footer/nav */
}

.dark-mode a {
  color: #ff8c00; /* Accent link color */
}

.dark-mode .btn {
  background-color: #333;
  color: #fff;
  border: 1px solid #ff8c00;
}

        body {
            font-family: Arial, sans-serif;
        }

        .search-bar {
            width: 100%;
            max-width: 500px;
            margin: 20px auto;
            padding: 10px;
            border: 1px solid grey;
            border-radius: 5px;
            font-size: 16px;
            display: block;
        }

        .category-section {
            margin-top: 30px;
            padding: 20px;
            background-color: rgb(245, 245, 245);
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .category-section h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 26px;
            color: #FF5733;
            text-transform: uppercase;
            border-bottom: 2px solid #FF5733;
            display: inline-block;
            padding-bottom: 5px;
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
            cursor: pointer;
            padding: 6px;
            border: 2px solid chocolate;
            font-size: 17px;
            font-weight: 600;
            background-color: rgb(228, 141, 79);
            color: aliceblue;
        }

        .recipe-card a:hover {
            background-color: rgb(245, 245, 245);
            color: chocolate;
        }

        /* video */
        iframe {
    width: 100%;
    max-width: 600px;
    height: 350px;
    margin: 20px 0;
    border-radius: 10px;
    border: 2px solid #ddd;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.recipe-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 20px;
    font-family: Arial, sans-serif;
    color: #333;
}

.recipe-container img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin-bottom: 20px;
}

    </style>
</head>
<body>
    <a href="../index.php">BACK TO HOME</a>
    <h1 style="text-align: center;">Submitted Recipes</h1>
    <!-- <button id="dark-mode-btn" class="btn dark-mode-toggle">🌙 Dark Mode</button> -->
    <!-- Search Bar -->
    <input type="text" id="search" class="search-bar" placeholder="Search for recipes...">

    <!-- Recipe Categories -->
    <?php foreach ($recipes_by_category as $category => $recipes): ?>
        <?php if (!empty($recipes)): ?>
            <div class="category-section" id="<?php echo strtolower($category); ?>">
                <!-- Category Name -->
                <h2><?php echo htmlspecialchars($category); ?></h2>
                
                <!-- Recipes Grid -->
                <div class="recipe-grid">
                    <?php foreach ($recipes as $recipe): ?>
                        <div class="recipe-card">
                            <img src="../uploads/<?php echo $recipe['image']; ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                            <h3 class="recipe-title"><?php echo htmlspecialchars($recipe['title']); ?></h3>
                            <div class="rating">
                                <?php 
                                $average_rating = round($recipe['average_rating'], 1); // Round to one decimal
                                for ($i = 0; $i < floor($average_rating); $i++): ?>
                                    ★
                                <?php endfor; ?>
                                <?php for ($i = floor($average_rating); $i < 5; $i++): ?>
                                    ☆
                                <?php endfor; ?>
                                <span>(<?php echo $average_rating; ?> / 5)</span>
                            </div>
                            <a href="recipe_detail.php?id=<?php echo $recipe['id']; ?>">View Recipe</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <div class="recipe-card">
    <img src="../uploads/<?php echo $recipe['image']; ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
    <h3 class="recipe-title"><?php echo htmlspecialchars($recipe['title']); ?></h3>
    <div class="rating">
        <?php 
        $average_rating = round($recipe['average_rating'], 1); 
        for ($i = 0; $i < floor($average_rating); $i++): ?>
            ★
        <?php endfor; ?>
        <?php for ($i = floor($average_rating); $i < 5; $i++): ?>
            ☆
        <?php endfor; ?>
        <span>(<?php echo $average_rating; ?> / 5)</span>
    </div>


    <a href="recipe_detail.php?id=<?php echo $recipe['id']; ?>">View Recipe</a>
</div>


    <script>
    // Search Functionality
    document.getElementById('search').addEventListener('keyup', function () {
        const searchInput = this.value.toLowerCase();
        const sections = document.querySelectorAll('.category-section');
        let foundCategory = false;

        sections.forEach(function (section) {
            const categoryName = section.querySelector('h2').textContent.toLowerCase();
            const cards = section.querySelectorAll('.recipe-card');
            let foundInRecipes = false;

            // Check if the search matches a recipe title
            cards.forEach(function (card) {
                const title = card.querySelector('.recipe-title').textContent.toLowerCase();
                if (title.includes(searchInput)) {
                    card.style.display = "block"; // Show matching recipes
                    foundInRecipes = true;
                } else {
                    card.style.display = "none"; // Hide non-matching recipes
                }
            });

            // Check if the search matches a category
            if (categoryName.includes(searchInput) && !foundCategory) {
                foundCategory = true;
                section.style.display = "block"; // Ensure the category section is visible
                cards.forEach(function (card) {
                    card.style.display = "block"; // Show all recipes in this category
                });

                // Scroll to the first recipe in the matched category
                if (cards.length > 0) {
                    cards[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            } else if (!foundInRecipes) {
                section.style.display = "none"; // Hide sections with no matching recipes or category
            }
        });
    });
</script>
<script src="js/script.js"></script>
</body>
</html>
