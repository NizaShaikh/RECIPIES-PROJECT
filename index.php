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


  <!-- <div class="hero">
    <div class="hero-container">
      <div class="hero-text">
        <h2>MOUTH WATERING RECIPES</h2>
        <p id="eat">Eat well, Live well</p>
      </div>
    </div>
  </div> -->

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
</body>
</html>
