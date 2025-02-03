<!-- recipe of the day -->
<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "recipe_db");

// Recipe of the Day Query
$recipeQuery = "SELECT id, title, description, image FROM recipes ORDER BY RAND() LIMIT 1";
$recipeResult = $conn->query($recipeQuery);
$recipe = $recipeResult->fetch_assoc();
?>





<!-- rating and users count -->
<?php
// Include the database connection file
require 'php/db_connect.php';

// Initialize variables for the counts
$totalUsers = 0;
$totalRatings = 0;

try {
    // Fetch total users
    $userQuery = "SELECT COUNT(*) as userCount FROM users";
    $userResult = $conn->query($userQuery);
    $userRow = $userResult->fetch_assoc();
    $totalUsers = $userRow['userCount'];

    // Fetch total ratings
    $ratingQuery = "SELECT COUNT(*) as ratingCount FROM comments WHERE rating IS NOT NULL";
    $ratingResult = $conn->query($ratingQuery);
    $ratingRow = $ratingResult->fetch_assoc();
    $totalRatings = $ratingRow['ratingCount'];
} catch (Exception $e) {
    echo "Error fetching data: " . $e->getMessage();
}
?>



<?php
include 'php/db_connect.php'; // Database connection
session_start(); // Start the session to manage logged-in users

// Query to fetch recent recipes with their ratings
$query = "
SELECT r.id, r.title, r.image, 
       COALESCE(AVG(c.rating), 0) AS avg_rating 
FROM recipes r 
LEFT JOIN comments c ON r.id = c.recipe_id 
GROUP BY r.id, r.title, r.image 
LIMIT 7";
$result = $conn->query($query);
?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FOOD RECIPES PAGE</title>
  <link rel="stylesheet" href="style.css">
  <script src="js/interactivity.js"></script>
  <style>

.content-container {
    display: flex;
    justify-content: space-between; /* Adds spacing between the sections */
    align-items: flex-start; /* Align items at the top */
    gap: 20px; /* Adds spacing between the two sections */
    padding: 20px;
}

.card {
    flex: 1; /* Adjust the width of the card section */
    max-width: 40%; /* Prevent the card from growing too wide */
    background: white;
    /* border-radius: 10px; */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    overflow: hidden;
    border-color:2px solid black ;
}

.card img {
    width: 100%;
    border-bottom: 3px solid #e67e22;
}

.card-content {
    padding: 20px;
}

.card-content h2 {
    font-size: 1.8rem;
    color: #e67e22;
    margin-bottom: 10px;
}

.card-content p {
    font-size: 1rem;
    color: #555;
    margin-bottom: 20px;
}

.card-content .btn {
    text-decoration: none;
    background-color: #e67e22;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 1rem;
    transition: 0.3s;
}

.card-content .btn:hover {
    background-color: #d35400;
}

.journey-container {
    flex: 1; /* Adjust the width of the journey section */
    max-width: 50%; /* Prevent the journey section from growing too wide */
    background: #fafafa;
    border-radius: 10px;
    padding: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    /* height: 130px; */
}

.journey-container h2 {
    font-size: 2rem;
    color: #2980b9;
    margin-bottom: 10px;
}

.journey-stats {
    display: flex;
    justify-content: space-around; /* Space out the stats */
    gap: 20px; /* Adds spacing between the stats */
}

.stat {
    background: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 100px;
}

.stat h3 {
    font-size: 2rem;
    color: #3498db;
    margin-bottom: 5px;
}

.stat p {
    font-size: 1rem;
    color: #555;
}


    /* recipe of day */
.container {
    display: flex;
    justify-content: space-between;
    gap: 30px;
    padding: 20px;
}
.card {
    width: 48%;
    height: 350px; /* Reduced length */
    background: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 10px;
    overflow: hidden;
    text-align: center;
    display: flex;
    flex-direction: column;
}
.card img {
    width: 100%;
    height: 60%;
    object-fit: cover;
}
.card-content {
    padding: 15px;
    flex: 1;
}
.card-content h2 {
    font-size: 1.5rem;
    color: #333;
}
.card-content p {
    color: #555;
    font-size: 1rem;
}
.related-recipes {
    margin-top: 10px;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.related-recipe-item {
    width: 100%;
    text-align: left;
    display: flex;
    align-items: center;
}
.related-recipe-item img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    margin-right: 10px;
    border-radius: 5px;
}
.related-recipe-item span {
    font-size: 0.9rem;
    color: #333;
}
.btn {
    margin-top: 10px;
    padding: 10px 15px;
    background: #e48d4f;
    color: white;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
}
.btn:hover {
    background: #cc753b;
}






/* Personal Chef Services Section */
.personal-chef-services {
    padding: 50px 20px;
    background-color: #f8f8f8; /* Light gray background */
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.chef-services-container {
    display: flex;
    flex-wrap: wrap;
    max-width: 1200px;
    align-items: center;
    gap: 20px;
}

.chef-image {
    width: 45%; /* Adjust image size */
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.chef-services-content {
    width: 50%;
    text-align: left;
}

.chef-services-content h2 {
    font-size: 36px;
    color: #FF5733; /* Matches theme */
    margin-bottom: 20px;
}

.chef-services-content p {
    font-size: 18px;
    color: #333;
    line-height: 1.6;
    margin-bottom: 20px;
}

.chef-contact-btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #FF5733;
    color: white;
    text-transform: uppercase;
    font-size: 14px;
    font-weight: bold;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease, color 0.3s ease;
    margin-left: 200px;
}

.chef-contact-btn:hover {
    background-color: white;
    color: #FF5733;
    border: 2px solid #FF5733;
}


/* journey section  */
.journey-container {
  background: #fafafa;
  padding: 50px 20px;
  text-align: center;
}

.journey-container h2 {
  font-size: 2rem;
  color: #2980b9;
  margin-bottom: 30px;
}

.journey-stats {
  display: flex;
  justify-content: center;
  gap: 50px;
  flex-wrap: wrap;
}

.stat {
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  text-align: center;
  width: 90px;
}

.stat h3 {
  font-size: 2.5rem;
  color: #3498db;
  margin-bottom: 10px;
}

.stat p {
  font-size: 1rem;
  color: #555;
}

.journey-section {
            text-align: center;
            margin: 50px auto;
            font-family: Arial, sans-serif;
        }

        .journey-metric {
            display: inline-block;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 120px;
            background-color: #f9f9f9;
        }
        .journey-metric h1 {
            margin: 0;
            font-size: 3em;
            color: #ff5722;
        }
        .journey-metric p {
            margin: 5px 0;
            font-size: 1.2em;
            color: #555;
        }



    body {
      font-family: Arial, sans-serif;
    }

    .recipes-section {
      padding: 20px;
      text-align: center;
    }

    .recipe-card {
      display: inline-block;
      margin: 15px;
      padding: 10px;
      width: 220px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      text-align: center;
    }

    .recipe-card img {
      max-width: 100%;
      height: 150px;
      object-fit: cover;
    }

    .recipe-card h3 {
      margin-top: 10px;
      font-size: 18px;
    }

    .read-more {
      display: inline-block;
      margin-top: 20px;
      /* padding: 10px 20px;
      font-size: 16px;
      background-color: #e48d4f;
      color: white;
      border: none;
      /* border-radius: 5px; */
       text-decoration: none;  
      cursor:pointer;
  padding: 8px;
  border:2px solid chocolate;
  font-size: 14px;
  font-weight: 700;
  background-color: rgb(228, 141, 79);
  color: aliceblue;
    }

    .read-more:hover {
      /* /* background-color: #c76a3c; */
      text-decoration: none; 
      background-color: rgb(245, 245, 245);
  color: chocolate;
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

    /* Styling for the logout and signup buttons */
    .auth-btn {
      cursor: pointer;
      padding: 6px;
      border: 2px solid chocolate;
      font-size: 17px;
      font-weight: 600;
      background-color: rgb(228, 141, 79);
      color: aliceblue;
      width: 80px;
      position: absolute;
      right: 120px;
      top: 25px;
      text-align: center;
      text-decoration: none;
    }

    .auth-btn:hover {
      background-color: rgb(245, 245, 245);
      color: chocolate;
    }

    /* Star rating */
    .rating {
      font-size: 16px;
      color: #ffb600;
    }

    .stars {
      display: inline-block;
    }

    .stars::before {
      content: "★★★★★"; /* 5 stars */
      background: linear-gradient(90deg, #ffb600 calc(var(--rating) * 20%), #ddd calc(var(--rating) * 20%));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    
#btn{
  position: absolute;
  top: 25px;
  right:30px;
  cursor:pointer;
  padding: 8px;
  border:2px solid chocolate;
  font-size: 14px;
  font-weight: 700;
  background-color: rgb(228, 141, 79);
  color: aliceblue;
}

#btn:hover{
  background-color: rgb(245, 245, 245);
  color: chocolate;
}

/* body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
} */

.newsletter-container {
    max-width: 600px;
    margin: 40px auto;
    padding: 20px;
    border:2px solid  chocolate;
    box-shadow: 12px 12px 12px rgba(0, 0., 0, 0.3);
}

.newsletter-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.newsletter-text {
    flex: 2;
    line-height: 1.6;
    font-style: italic;
}

h2 {
    margin-bottom: 10px;
    color: rgb(233, 135, 64);
}

p {
    margin-bottom: 15px;
    color: rgb(233, 135, 64);
}
#eat{
  color: rgb(233, 135, 64);
}

.newsletter-form {
    display: flex;
}

.newsletter-form input[type="email"] {
    padding: 10px;
    width: 250px;
    border: 1px solid #ddd;
    border-radius: 4px 0 0 4px;
}

.newsletter-form button {
    /* padding: 10px 20px; */
    /* background-color: #ff6f61; */
    /* color: white; */
    /* border: none; */
    /* border-radius: 0 4px 4px 0; */
    cursor: pointer;
  padding: 8px;
  border:2px solid chocolate;
  font-size: 14px;
  font-weight: 700;
  background-color: rgb(228, 141, 79);
  color: aliceblue;
}

.newsletter-form button:hover {
  background-color: rgb(245, 245, 245);
  color: chocolate;
}

.newsletter-image {
    flex: 1;
    text-align: right;
}

.newsletter-image img {
    width: 150px;
    height: auto;
    border-radius: 8px;
}

body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.footer {
    background-color: #f8f8f8;
    padding: 40px 20px;
    border-top: 1px solid #e5e5e5;
}

.footer-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    max-width: 1200px;
    margin: 0 auto;
    flex-wrap: wrap;
}

.footer-brand {
    flex: 1;
    text-align: left;
}

.footer-logo {
    width: 150px;
    margin-bottom: 20px;
}

.newsletter-button {
  cursor: pointer;
  padding: 8px;
  border:2px solid chocolate;
  font-size: 14px;
  font-weight: 700;
  background-color: rgb(228, 141, 79);
  color: aliceblue;
  width: 200px;
}

.newsletter-button:hover {
  color: rgb(228, 141, 79);
  background-color: aliceblue;
}

.social{
  margin-top: 60px;
  margin-left: -10px;
  position: absolute;
}

.icons a{
         text-decoration: none;
         padding-left: 7px;
         margin-top: 1px;
      }
      .icons a:hover{
         text-decoration:underline ;
      }

  #insta{
     background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%,#d6249f 60%,#285AEB 90%);
     background-clip: text;
     -webkit-text-fill-color: transparent;
}

#fb{
  color: #386fc1;
}

#pin{
  color: red;
}

#twitter{
   color: rgb(61, 175, 220);
}

#yt{
  color: red;
}

.footer-links {
    flex: 2;
    display: flex;
    justify-content: space-between;
    text-align: left;
}

.footer-links div h4 {
    color: #333;
    font-size: 16px;
    margin-bottom: 15px;
}

.footer-links-1{
  margin-left: 320px;
}
.footer-links-2{
  margin-right: 120px;
}

.footer-links div ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links div ul li {
    margin-bottom: 8px;
}

.footer-links div ul li a {
    color: #007bff;
    text-decoration: none;
    font-size: 14px;
}

.footer-links div ul li a:hover {
    text-decoration: underline;
}

.slideshow-container {
  position: relative;
  max-width: 100%; 
  height: 350px; /* Adjust according to the size you want */
   margin: auto;
  overflow: hidden;
}

.mySlides {
  display: none;
}

.mySlides img {
  width: 100%;
  height: 400px; /* Adjust this height based on your design */
  object-fit: cover;
}

.slideshow-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    /* color: white; */
    color: #fff; 
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
    padding: 20px 40px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); Add a subtle shadow
    width: 35%; /* Width of the text box */
    height: 70px;
}

.slideshow-text h1 {
    font-size: 38px; /* Large bold heading */
    font-weight: bold;
    margin: 0;
    text-transform: uppercase; /* Makes the text all uppercase */
    letter-spacing: 2px; /* Adds space between letters */
    text-shadow: 2px 4px 4px rgba(0, 0, 0, 0.5); /* Text shadow for better readability */
    color: white;
}

.slideshow-text p {
    font-size: 20px;
    margin-top: 10px;
    letter-spacing: 2px;
    font-style: italic;
    text-shadow: 1px 2px 3px rgba(0, 0, 0, 0.5);
    color: white;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .slideshow-text h1 {
        font-size: 36px; /* Smaller heading for smaller screens */
    }

    .slideshow-text p {
        font-size: 18px;
    }
}

@keyframes fadeEffect {
  from {opacity: 0.5} 
  to {opacity: 1}
}  

/* Default Light Mode */
:root {
    --bg-color: #ffffff;
    --text-color: #000000;
    /* --header-bg: #f4f4f4; */
    --card-bg: #e9e9e9;
    --link-color: #0077cc;
}

/* Dark Mode */
[data-theme="dark"] {
    --bg-color:rgb(49, 49, 49);
    --text-color: #ffffff;
    --header-bg:rgb(49, 49, 49);
    --card-bg: #242424;
    
    --link-color: #4fa6ff;
}

/* Apply Theme Variables */
body {
    background-color: var(--bg-color);
    color: var(--text-color);
}

header {
    background-color: var(--header-bg);
}

.recipe-card {
    background-color: var(--card-bg);
    padding: 10px;
    border-radius: 8px;
}

a {
    color: var(--link-color);
}

.theme-button{
    cursor: pointer;
    border: none;
    padding: 8px 12px;
    background-color: var(--card-bg);
    color: var(--text-color);
    border-radius: 5px;
}

/* Dark Mode Styles */
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


/* Newsletter Section */
#cooking-contest-newsletter {
    background-color:rgb(255, 255, 255);
    padding: 40px;
    text-align: center;
    border: 2px solid #e3e3e3;
    border-radius: 8px;
    height: 250px;
    max-width: 900px;
    margin: 20px auto;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.newsletter-container{
  margin-top: -10px;
}

.newsletter-container h2 {
    font-size: 24px;
    color: #333;
    margin-bottom: 10px;
}

.newsletter-container p {
    font-size: 16px;
    color: #555;
    margin-bottom: 10px;
}

#newsletter-form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

#email {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
    outline: none;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
}

#email:focus {
    border-color: #ff8c00;
    box-shadow: 0 0 5px rgba(255, 140, 0, 0.4);
}

#subscribe-btn {
    /* background-color: #ff8c00; */
    /* color: white; */
    background-color: rgb(228, 141, 79);
    color: aliceblue;
    padding: 12px;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#subscribe-btn:hover {
    background-color: #e67e22;
}

/* Feedback message styling */
#newsletter-feedback {
    margin-top: 15px;
    font-size: 14px;
    color: green;
    display: none; /* Shown dynamically with JS */
}
/* Newsletter Form Styles */
#newsletter-form {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin: 20px auto;
  width: 100%;
  max-width: 400px;
}

#newsletter-form input[type="email"] {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border: 2px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
}
/* 
#subscribe-btn {
  padding: 10px 20px;
  background-color: #4caf50;
  color: white;
  font-size: 18px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

#subscribe-btn:hover {
  background-color: #45a049;
} */

/* Success Message */
p {
  font-size: 18px;
  margin-top: 10px;
  text-align: center;
}

/* Container Styling */
.journey-container {
    background: linear-gradient(120deg, #f5f5f5, #eaeaea, #ffffff); /* Soft neutral shades */
    background-size: 200% 200%;
    animation: backgroundMove 10s infinite;
    padding: 30px 20px;
    max-width: 700px; /* Reduced width */
    margin: 40px auto; /* Center the section */
    text-align: center;
    border-radius: 10px;
    color: #333; /* Neutral text color */
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    font-family: 'Verdana', sans-serif;
}

/* Title Styling */
.journey-container h2 {
    font-size: 28px; /* Reduced size */
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #555; /* Subtle dark gray */
    text-shadow: 1px 2px 4px rgba(0, 0, 0, 0.1);
}

/* Stats Section */
.journey-stats {
    display: flex;
    justify-content: space-around; /* Space stats equally */
    gap: 20px;
    flex-wrap: wrap; /* Wrap stats on smaller screens */
}

.stat {
    text-align: center;
    animation: fadeIn 1.5s ease-in-out;
    flex: 1;
    min-width: 120px; /* Ensure consistent spacing */
}

.stat h3 {
    font-size: 32px; /* Adjusted size */
    margin-bottom: 10px;
    color:rgb(233, 135, 64); /* Dark gray for numbers */
    text-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    animation: countUp 2s ease-in-out;
}

.stat p {
    font-size: 16px;
    font-weight: bold;
    color: #666; /* Softer gray */
}

/* Background Animation */
@keyframes backgroundMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Fade In Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}

/* Number Animation */
@keyframes countUp {
    from { transform: scale(0.8); color: #888; }
    to { transform: scale(1); color: #222; }
}



  </style>
  <script src="https://kit.fontawesome.com/9e9cdc6ad3.js" crossorigin="anonymous"></script>
</head>

<body>
  <header>
    <h1><strong>TASTY TALES</strong></h1>
  </header>
  
  <nav class="nav-links">
    <a class="links" href="index.php">HOME</a>
    <a class="links" href="about.html">ABOUT US</a>
    <a class="links" href="submit_recipe.html">SUBMIT RECIPES</a>
    <a class="links" href="php/display_recipes.php">VIEW RECIPES</a>
    <a class="links" href="blog.php">BLOG</a>
    <a class="links"href="kitchen_tips.html">KITCHEN TIPS</a>
    
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
      <a href="php/logout.php" class="auth-btn">LOGOUT</a>
      <?php else: ?>
        <a href="php/signup.php" class="auth-btn">SIGNUP</a>
        <?php endif; ?>
        <input type="button" id="btn" value="CONTACT" onclick="window.location.href='contact.html';" />

        <!-- Add this in the header -->
        <button id="dark-mode-btn" class="btn dark-mode-toggle">🌙 Dark Mode</button>
        <!-- <button id="theme-toggle" class="theme-button">🌙 Dark Mode</button> -->
      </nav>

  <div class="slideshow-container">
    <div class="mySlides fade">
        <img src="images/n1.jpg" style="width:100%">
    </div>

    <div class="mySlides fade">
        <img src="images/i2.jpg" style="width:100%">
    </div>

    <div class="mySlides fade">
        <img src="images/pexels-catscoming-674574.jpg" style="width:100%">
    </div>

    <div class="mySlides fade">
        <img src="images/p1.jpg" style="width:100%">
    </div>
    <div class="mySlides fade">
        <img src="images/p2.jpg" style="width:100%">
    </div>
    <div class="mySlides fade">
        <img src="images/n4.jpg" style="width:100%">
    </div>

    <!-- Add more slides as needed -->

    <!-- Text overlay that stays constant -->
    <div class="slideshow-text">
        <h1>MOUTH WATERING RECIPES</h1>
        <p>Eat well, Live well</p>
    </div>
</div>

  <div class="recipes">
  <div class="food">
    <a href="drinks.html"><img id="drinks" src="images/drink.jpg" alt="error" height="200px" width="230px">
    <p class="para">Drinks</p></a>
  </div>

  <div class="food">
    <a href="starters.html"><img id="starters" src="images/starters.avif" alt="error" height="200" width="230">
    <p class="para">Starters</p></a>
  </div>

    <div class="food">
    <a href="main-course.html"><img id="maincourse"src="images/main.avif" alt="error" height="200" width="230" >
    <p class="para">Main Course</p></a>
  </div>

    <div class="food">
    <a href="dessert.html"><img id="desserts"src="images/pexels-ash-376464.jpg" alt="error" height="200" width="230">
    <p class="para">Desserts</p></a>
  </div>
</div>

<section id="cooking-contest-newsletter">
    <div class="newsletter-container">
        <h2>Join Our Cooking Contest Newsletter</h2>
        <p>Stay updated with the latest cooking contests and win exciting prizes!</p>
        <form id="newsletter-form" action="php/newsletter_signup.php" method="POST">
            <input 
                type="email" 
                name="email" 
                id="email" 
                placeholder="Enter your email" 
                required 
            />
            <button type="submit" id="subscribe-btn">Subscribe</button>
        </form>
        <p id="newsletter-feedback"></p>
    </div>
</section>

<div class="content-container">
    <!-- Recipe of the Day -->
    <div class="card">
        <img src="uploads/<?php echo $recipe['image']; ?>" alt="Recipe of the Day">
        <div class="card-content">
            <h2>Recipe of the Day</h2>
            <p><?php echo $recipe['title']; ?></p>
            <a href="php/recipe_detail.php?id=<?php echo $recipe['id']; ?>" class="btn">View Recipe</a>
        </div>
    </div>

    <!-- Journey So Far -->
    <div class="journey-container">
        <h2>Our Journey So Far</h2>
        <div class="journey-stats">
            <div class="stat">
                <h3 class="count" id="users-count"><?php echo $totalUsers; ?>+</h3>
                <p>Users</p>
            </div>
            <div class="stat">
                <h3 class="count" id="ratings-count"><?php echo $totalRatings; ?>+</h3>
                <p>Ratings</p>
            </div>
        </div>
    </div>
</div>


<!-- Personal Chef Services Section -->
<section class="personal-chef-services">
    <div class="chef-services-container">
        <img src="images/personal-chef.jpeg" alt="Personal Chef Services" class="chef-image">
        <div class="chef-services-content">
            <h2>Personal Chef Services</h2>
            <p>
                Experience the luxury of having your own personal chef! Whether you're hosting a private dinner, 
                a special event, or just want to enjoy customized meals at home, we've got you covered. 
                Our chefs bring creativity, fresh ingredients, and exquisite flavors right to your table.
            </p>
            <a href="contact.html" class="btn chef-contact-btn">Book Your Chef Now</a>
        </div>
    </div>
</section>


  <div class="recipes-section">
    <h2>RECENT RECIPES SUBMITTED BY OUR USERS</h2>
    <div class="recipe-list">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="recipe-card">
    <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
    <h3><?php echo $row['title']; ?></h3>
    <!-- Star rating display -->
    <div class="stars" style="--rating: <?php echo round($row['avg_rating'], 1); ?>;"></div>
    <!-- Added some margin for better spacing -->
    <div style="margin-bottom: 10px;"></div>
    <a href="php/recipe_detail.php?id=<?php echo $row['id']; ?>">View Recipe</a>
</div>

      <?php endwhile; ?>
    </div>
    <a href="php/display_recipes.php" class="read-more">Read More Recipes</a>
  </div>

    <div class="newsletter-container">
        <div class="newsletter-content">
            <div class="newsletter-text">
                <h2>Join Our Newsletter</h2>
                <p>Sign up for tasty recipes Cookbook!The eBook includes our most popular 25 recipes in a beautiful, easy to download format. Enter your email and we'll send it right over!
                </p>
                <form action="php/send_recipe_book.php" method="post" class="newsletter-form">
                    <input type="email" name="email" placeholder="Enter your email" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
            <div class="newsletter-image">
                <img src="images/recbook.jpg" alt="Delicious Recipe">
            </div>
        </div>
       
    </div>


  <!-- Footer Section -->
  <footer class="footer">
        <div class="footer-container">
            <div class="footer-brand">

                <button class="newsletter-button">NEWSLETTERS</button>
            </div>
           

            <!-- !-- social media platfrom contact--> 
<div class="social">
<h3 class="joinn">Join Us At </h3>   

<div class="icons">

<a href="https://www.youtube.com/@tastytales" target="_blank" p id="yt" class="fa-brands fa-youtube fa-2x"></p></a>

<a href="#" p id="twitter" class="fa-brands fa-twitter fa-2x"></p></a>

<a href="https://www.pinterest.com/tasty_tales/" p id="pin" class="fa-brands fa-pinterest fa-2x"></p></a>

<a href="#" p id="fb" class="fa-brands fa-facebook fa-2x"></p></a>

<a href="https://www.instagram.com/_tastytales_/" target="_blank" p id="insta" class="fa-brands fa-square-instagram fa-2x"></p></a>
</div>
</div>
<!-- <h1><strong>TASTY TALES</strong></h1> -->
            <div class="footer-links">
                <div class="footer-links-1">
                    <h4>Recipes</h4>
                    <ul>
                        <li><a href="php/display_recipes.php">User Recipes</a></li>
                        <li><a href="kitchen_tips.html">Kitchen Tips</a></li>
                        <li><a href="recipes.html">Our Recipes</a></li>
                    </ul>
                </div>
                <div class="footer-links-2">
                    <h4>Information</h4>
                    <ul>
                        <li><a href="about.html">About Us</a></li>
                        <li><a href="https://www.dotdashmeredith.com/brands-privacy">Privacy Policy</a></li>
                        <li><a href="https://www.dotdashmeredith.com/brands-termsofservice">Terms of Service</a></li>
                        <li><a href="blog.php">Blog</a></li>
                        <li><a href="contact.html">Contact</a></li>

                    </ul>
                </div>
            </div>
            </div>
        </div>



  <footer id="footer">&copy; <span id="date"></span> TastyTales Built By NizaShaikh</footer>

  <!-- recipe of the day  -->
  <script>
    // Automatic scrolling for the slider
    const slider = document.querySelector('.recipe-slider');
    let scrollAmount = 0;

    setInterval(() => {
        if (slider.scrollWidth - slider.clientWidth === scrollAmount) {
            scrollAmount = 0;
        } else {
            scrollAmount += 220;
        }
        slider.scrollTo({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }, 3000);
</script>



  <script>
    function animateCount(id, target) {
        let count = 0;
        const speed = 20; // Higher is slower
        const increment = Math.ceil(target / 100);

        const counter = setInterval(() => {
            count += increment;
            if (count >= target) {
                count = target;
                clearInterval(counter);
            }
            document.getElementById(id).textContent = count + "+";
        }, speed);
    }

    document.addEventListener("DOMContentLoaded", () => {
        animateCount("users-count", <?php echo $totalUsers; ?>);
        animateCount("ratings-count", <?php echo $totalRatings; ?>);
    });
</script>



  <script>

  let slideIndex = 0;
    showSlides();

    function showSlides() {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}    
        slides[slideIndex-1].style.display = "block";  
        setTimeout(showSlides, 2000); // Change image every 3 seconds
    }
</script>
  <script>
    // For dynamically setting the year in the footer
    document.getElementById('date').textContent = new Date().getFullYear();
  </script>
  <script src="js/script.js"></script>

</body>
</html>
