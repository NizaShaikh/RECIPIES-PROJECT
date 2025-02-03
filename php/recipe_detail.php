<?php

include 'db_connect.php';

if (isset($_GET['id'])) {
    $recipe_id = $_GET['id'];
    $query = "SELECT * FROM recipes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $recipe = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $recipe['title']; ?></title>
    <style>
        /* General body styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        /* Container for the recipe content */
        .recipe-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        /* Title Styling */
        .recipe-container h1 {
            font-size: 28px;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        /* Consistent Image Size Styling */
        .recipe-container img {
            width: 50%;
            max-height: 400px; /* Ensuring consistent image height */
            object-fit: cover;  /* Image crops but maintains aspect ratio */
            border:2px solid grey;
            margin-bottom: 20px;
           display: block;
           margin-left: 240px;
       
        }

        /* Rating Stars Styling */
        .rating {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: orange;
        }

        /* Recipe Detail Section Styling */
        .recipe-details {
            margin-top: 20px;
            line-height: 1.7;
            color: #555;
        }

        .recipe-details h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #444;
        }

        .recipe-details p {
            font-size: 16px;
            margin-bottom: 20px;
            color: #666;
        }

        /* Back Button Styling */
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 18px;
            background-color: #ff6600;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .back-link:hover {
            background-color: #ff8c1a;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .recipe-container {
                padding: 15px;
            }

            .recipe-container h1 {
                font-size: 28px;              
            }

            .recipe-details h3 {
                font-size: 22px;
            }

            .recipe-details p {
                font-size: 14px;
            }
        }

        a{
    color: black;
}
a:hover{
    color: red;
}

/* video */
.video-container {
    position: relative;
    width: 100%;
    max-width: 600px;
    margin: 20px auto;
    overflow: hidden;
    padding-top: 56.25%;
    margin-bottom: -150px; 
    /* Aspect ratio for 16:9 videos */
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 90%;
    height: 60%;
    border: none;
}


    </style>
</head>
<body>

    <a href="../index.php">BACK TO HOME</a>
<div class="recipe-container">
    <!-- Recipe Title -->
    <h1><?php echo $recipe['title']; ?></h1>
    <!-- Recipe Image -->
    <img src="../uploads/<?php echo $recipe['image']; ?>" alt="<?php echo $recipe['title']; ?>">

    <!-- Recipe Rating Display -->
<div class="rating">
    <?php 
    $average_rating = round($recipe['average_rating'], 1);  // Round to 1 decimal place
    echo str_repeat('★', floor($average_rating));  // Filled stars
    echo str_repeat('☆', 5 - floor($average_rating));  // Empty stars
    ?>
    <span>(<?php echo $average_rating; ?> / 5)</span>
</div>


<div class="recipe-card">
    <!-- <img src="uploads/<?php echo $recipe['image']; ?>" alt="Recipe Image"> -->
    <h3><?php echo $recipe['title']; ?></h3>
    <p><?php echo $recipe['description']; ?></p>


    <!-- Options: Share, Save, Download, Printable -->
    <div class="recipe-options">
            <button class="option-btn" onclick="shareRecipe()">
                <i class="fas fa-share-alt"></i> Share
            </button>
            <!-- <button class="option-btn" onclick="saveRecipe()">
                <i class="fas fa-bookmark"></i> Save
            </button> -->
            <button class="option-btn" onclick="downloadRecipe()">
                <i class="fas fa-download"></i> Download
            </button>
            <button class="option-btn" onclick="printRecipe()">
                <i class="fas fa-print"></i> Print
            </button>
        </div>


    <!-- Recipe Details -->
    <div class="recipe-details">
        <h3>Description:</h3>
        <p><?php echo $recipe['description']; ?></p>

        <h3>Ingredients:</h3>
        <p><?php echo nl2br($recipe['ingredients']); ?></p>

        <h3>Instructions:</h3>
        <p><?php echo nl2br($recipe['instructions']); ?></p>
    </div>

  <!-- Video Section -->
  <?php if (!empty($recipe['video_url'])): ?>
                <h3>Watch Recipe Video</h3>
                <div class="video-container">
                    <iframe 
                        width="100%" 
                        height="315" 
                        src="<?php echo htmlspecialchars($recipe['video_url']); ?>" 
                        title="Recipe Video" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            <?php endif; ?>
        <!-- </div> -->
        
    


     <!-- Back to Recipes Button -->
    <a href="display_recipes.php" class="back-link">Back to Recipes</a>
</div>


<?php
// Include database connection file
include 'db_connect.php'; 

// Handle comment submission
// Inside the comment submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $recipe_id = $recipe['id'];  // Use the current recipe's ID
    
    $query = "INSERT INTO comments (username, comment, rating, recipe_id) VALUES ('$username', '$comment', '$rating', '$recipe_id')";
    
    if (mysqli_query($conn, $query)) {
        // Update the average rating for the recipe
        $query = "UPDATE recipes 
                  SET average_rating = (SELECT AVG(rating) FROM comments WHERE recipe_id = '$recipe_id')
                  WHERE id = '$recipe_id'";
        mysqli_query($conn, $query);
    } else {
        error_log('Database error: ' . mysqli_error($conn));
    }
}

// Fetch comments for the current recipe
$sql = "SELECT * FROM comments WHERE recipe_id = '$recipe_id' ORDER BY created_at DESC";
$result = $conn->query($sql);
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMMENT</title>
    <style>
.comment-section {
    width: 80%;
    margin: 20px auto;
    background-color: white;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.comment-section h3 {
    margin-top: 0;
}

form {
    margin-bottom: 20px;
}

input, textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
}

button{
  
  cursor:pointer;
  padding: 8px;
  border:2px solid chocolate;
  font-size: 14px;
  font-weight: 700;
  background-color: rgb(228, 141, 79);
  color: aliceblue;
}

button:hover{
  background-color: rgb(245, 245, 245);
  color: chocolate;
}

#comments h4 {
    margin-top: 0;
}

/* Styling the comment section */
.comment-section {
    margin-top: 30px;
}

.comment-list {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.comment-item {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 5px;
}

.comment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
}

.comment-header strong {
    font-size: 16px;
    color: #333;
}

.comment-date {
    font-size: 12px;
    color: #888;
}

.comment-content {
    font-size: 14px;
    color: #555;
    margin: 0;
}

.no-comments {
    font-size: 14px;
    color: #999;
    text-align: center;
}

.comment-list li {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.comment-list li:last-child {
    border-bottom: none;
}

/* Additional styling for the form */
.comment-section form {
    margin-bottom: 20px;
}

.comment-section input[type="text"],
.comment-section textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

.rating input {
    display: none;
}

.rating label {
    font-size: 2em;
    color: lightgray;
    cursor: pointer;
}

.rating input:checked ~ label,
.rating label:hover,
.rating label:hover ~ label {
    color: gold;
}

.comment-box {
    border: 1px solid #ccc;
    padding: 10px;
    margin-bottom: 10px;
}

.comment-box strong {
    font-size: 1.2em;
}

.comment-box p {
    margin: 5px 0;
}

.comment-box .rating {
    color: gold;
}

/* share save */
.recipe-options {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.recipe-options button {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 8px 12px;
    background-color: rgb(228, 141, 79);
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

.recipe-options button:hover {
    background-color:rgb(255, 255, 255);
    color: orangered;
}

.recipe-options i {
    font-size: 1rem;
}
</style>
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    rel="stylesheet"/>

</head>
<body>
     <!-- Comment Submission Form -->
     <section class="comment-section">
        <h3>Leave a Comment</h3>
        <form action="" method="POST" class="comment-form">
            <input type="text" name="username" id="username" placeholder="Your Name" required>
            <textarea name="comment" id="comment" placeholder="Your Comment" required></textarea>
            
            <label for="rating">Your Rating</label>
    <div class="rating">
        <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label>
        <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label>
        <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label>
        <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label>
        <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
    </div><br>
            
            <button type="submit">Submit</button>
        </form>
    </section>

   <!-- Display Comments -->
   <section class="comment-section">
    <h3>Comments</h3>
    <ul class="comment-list">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li class='comment-item'>";
                echo "<div class='comment-header'><strong>" . htmlspecialchars($row['username']) . "</strong> <small class='comment-date'>Posted on: " . $row['created_at'] . "</small></div>";
                echo "<p class='comment-content'>" . htmlspecialchars($row['comment']) . "</p>";
                echo '<p>Rating: ' . str_repeat('☆', $row['rating']) . '</p>';
                echo "</li>";
            }   
        } else {
            echo "<li class='no-comments'>No comments yet. Be the first to comment!</li>";
        }
        ?>
    </ul>
</section>
    <script src="js/interactivity.js"></script>
<?php
// Close the database connection
$conn->close();
?>


<script>
    // share save opt
    
    function shareRecipe() {
    const shareData = {
        title: "Recipe of the Day",
        text: "Check out this amazing recipe on our website!",
        url: window.location.href, // Current page URL
    };

    if (navigator.share) {
        navigator.share(shareData)
            .then(() => alert("Recipe shared successfully!"))
            .catch((err) => console.error("Error sharing:", err));
    } else {
        alert("Sharing is not supported on this browser. Copy the link to share: " + shareData.url);
    }
}


function downloadRecipe() {
  const recipeContent = "Recipe of the Day: Delicious Cake\nIngredients:\n- Flour\n- Sugar\n- Eggs\nInstructions:\n1. Mix ingredients.\n2. Bake at 350°F for 30 minutes.";
  const blob = new Blob([recipeContent], { type: "text/plain" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = "recipe.txt"; // Downloaded file name
  a.click();
  URL.revokeObjectURL(url);
}

function printRecipe() {
  window.print(); // Opens the browser's print dialog
}

</script>
</body>
</html>
