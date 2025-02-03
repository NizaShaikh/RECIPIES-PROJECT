<?php
// Include database connection file
include 'php/db_connect.php'; 

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the submitted data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $rating =  mysqli_real_escape_string($conn, $_POST['rating']);
    // Insert the comment into the database
    $query = "INSERT INTO comments ( username,comment,rating ) VALUES ('$comment', '$username','$rating')";
    if (mysqli_query($conn, $query)) {
        // Success message (Optional)
        // echo '<div class="success">Comment submitted successfully!</div>';
    } else {
        // Log or handle error
        error_log('Database error: ' . mysqli_error($conn));
    }
}

// Fetch comments to display below the form
$sql = "SELECT * FROM comments ORDER BY created_at DESC";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Blog</title>
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
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

header {
    background-color: chocolate;
    color: white;
    text-align: center;
    padding: 30px 0;
}

h1 {
    margin: 0;
}

main {
    width: 80%;
    margin: 20px auto;
}

.blog-post {
    background-color: white;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.blog-post h2 {
    margin-top: 0;
}

.date {
    color: #999;
    font-size: 0.9em;
    margin-bottom: 10px;
}

.post-content {
    line-height: 1.6;
}

img {
    width: 30%;
    /* height: auto; */
    margin: 10px 0;
}

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
.links{
  margin-left: 200px;
  margin-right: 20px;
  margin-top: 20px;
  margin-bottom: 20px;
  display: inline-block;
  text-decoration: none;
  /* align-items: center; */
}

a:link{
  color: rgb(0, 0, 0);
}
a:hover{
  color:red;
}
a:active{
  color: rgb(104, 219, 87);
}

</style>
</head>
<body>
    <header>
        <h1>Welcome to Our Recipe Blog</h1>
        <p>Your go-to source for cooking tips, healthy eating, and delicious recipes!</p>
    </header>
         <!-- links -->
    <nav>
      <a class="links" href="index.php">HOME</a>
      <a class="links" href="about.html">ABOUT US</a>
       <a class="links" href="recipes.html">RECIPES</a>
       <a class="links"  href="blog.php">BLOG</a>
       <button id="dark-mode-btn" class="btn dark-mode-toggle">🌙 Dark Mode</button>
    </nav>    
    <main>
        <section class="blog-post">
            <h2>The Perfect Basic Burger Recipe</h2>
            <p class="date">Posted on September 20, 2024</p>
            <img src="images/burgerimages.jpg" alt="Burger Recipe Image" width="300">
            <p class="post-content">
                This hamburger patty recipe uses ground beef and an easy breadcrumb mixture. Nothing beats a simple hamburger on a warm summer evening! Learn how to make the perfect burger step-by-step.
                <br><br>
                <strong>Ingredients:</strong> Ground beef, breadcrumbs, egg, salt, pepper, and your favorite condiments.
                <br>
                <strong>Instructions:</strong> Preheat your grill, combine the ingredients, shape the patties, and grill them to perfection. Serve with fresh buns and toppings of your choice!
            </p>
        </section>

        <section class="blog-post">
            <h2>5 Tips to Perfect Your Baking Skills</h2>
            <p class="date">Posted on September 15, 2024</p>
            <img src="images/bakingimages.jpg" alt="Baking Tips Image" width="300">
            <p class="post-content">
                Whether you're a beginner baker or an experienced chef, these 5 tips will help you perfect your baking skills. From proper measuring techniques to understanding oven temperatures, we cover it all!
                <br><br>
                <strong>Tip #1:</strong> Always measure ingredients accurately.
                <br>
                <strong>Tip #2:</strong> Don't overmix your batter.
            </p>
        </section>
    </main>

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
    <script src="js/script.js"></script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>