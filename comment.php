<?php
session_start();

// Include database connection file
include 'php/db_connect.php'; 

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "<div class='alert'>
            <p style='color: red; text-align: center;'>You must be logged in to submit a recipe.</p>
            <p style='text-align: center;'>Please <a href='login.php'>log in</a> or <a href='signup.php'>sign up</a>.</p>
          </div>";
    exit(); // Stop the execution if not logged in
}

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the submitted data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $rating =  mysqli_real_escape_string($conn, $_POST['rating']);
    // Insert the comment into the database
    $query = "INSERT INTO comments ( username,comment,rating ) VALUES ('$username','$comment','$rating')";
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

    </style>
</head>
<body>
     <!-- Comment Submission Form -->
     <?php session_start(); ?>

<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
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
        <?php else: ?>
    <div style="color: red; text-align: center;">
        You must be logged in to comment or rate. <a href="login.php">Log in</a> or <a href="php/signup.php">Sign up</a>.
    </div>
<?php endif; ?>
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
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
