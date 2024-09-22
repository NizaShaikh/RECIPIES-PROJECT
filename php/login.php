<?php
session_start();
include 'db_connect.php'; // Make sure this file includes your MySQL connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to find the user
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // If password is correct, set session and redirect to index
            $_SESSION['email'] = $row['email']; // Store the user's email in session
            $_SESSION['loggedin'] = true; // Indicate the user is logged in
            header("Location: ../index.php"); // Redirect to the main page
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Invalid Password!'); window.history.back();</script>";
        }
    } else {
        // Invalid email
        echo "<script>alert('Invalid Email!'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
     <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Arial', sans-serif;
        /* background-color: white */
        background: url('../images/pexels-pixabay-326279 (1).jpg') no-repeat center center fixed;
        background-size: cover;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
.login-container {  
    border:2px solid #9b9b9b;
    padding:45px 30px 45px 30px ;
    box-shadow: 3px 2px 2px 2px rgb(136, 131, 131);
    background-color: rgba(231, 231, 231, 0.7); /* Slight transparency */
    margin-right: 750px;
    width: 27%;
}

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .input-group {
        margin-bottom: 20px;
    }
    
    .input-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .input-group input {
        width: 100%;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    
    .input-group small {
        color: red;
        visibility: hidden;
    }
    
    .btn {
        width: 100%;
        padding: 10px;
        cursor: pointer;
        border:2px solid chocolate;
  font-size: 17px;
  font-weight: 600;
  background-color: rgb(228, 141, 79);
  color: aliceblue;
    }
    
    .btn:hover {
        background-color: rgb(245, 245, 245);
  color: chocolate;
    }
    
    .options {
        text-align: center;
        margin-top: 20px;
    }
    
    .options a {
        color: #555;
        text-decoration: none;
    }
    
    .options a:hover {
        text-decoration: underline;
    }

   .back {
    color: black;
    margin-top: 19px;
    text-decoration: none; 
    font-size: 18px;   
}
.back :hover{
    color: red;
} */

</style>
</head>
<body>
  
    <div class="login-container">
        <form id="loginForm" action="login.php" method="POST"> <!-- Make sure this points to the PHP file -->
            <h2>LOG IN</h2>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="your@email.com" required>
                <small>Please fill out this required field.</small>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>

            <button type="submit" class="btn">LOG IN</button>

            <div class="options">
                <a href="#">Forgot Password?</a>
                <p>Don’t have an account yet? <a href="signup.php">Sign Up</a></p> <!-- Make sure this points to your signup page -->
                <a class="back" href="../index.php">Back to home</a>
            </div>
        </form>
    </div>
    <script src="js/interactivity.js"></script> <!-- Make sure this points to your JavaScript file -->
</body>
</html>
