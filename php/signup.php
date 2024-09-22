<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php'; //Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $email, $password);
    
    if ($stmt->execute()) { 
        // <!-- echo '<div style="background-color: #dff0d8; color: #3c763d; padding: 15px; border: 1px solid #d6e9c6;
        //  border-radius: 5px; font-size: 30px; text-align: center; margin: 20px auto; width: 50%;">
        //  Account created successfully</div>';    -->
          header('Location: ../index.php');  
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
    
.signup-modal {  
    border:2px solid #9b9b9b;
    padding:45px 30px 45px 30px ;
    box-shadow: 3px 2px 2px 2px rgb(136, 131, 131);
    background-color: rgba(231, 231, 231, 0.7); /* Slight transparency */
    margin-right: 750px;
    width: 27%;
}

h2 {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
    text-align: left;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="email"],
input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    margin-bottom: 10px;
}

.signup-btn {
    width: 100%;
        padding: 8px;
        cursor: pointer;
        border:2px solid chocolate;
  font-size: 17px;
  font-weight: 600;
  background-color: rgb(228, 141, 79);
  color: aliceblue;
}

.signup-btn:hover {
   
    background-color: rgb(245, 245, 245);
    color: chocolate;
}

/* Optional link styles for Log In */
p {
    margin-top: 15px;
}

p a {
    color: rgb(228, 141, 79);
    text-decoration: none;
}

p a:hover {
    text-decoration: underline;
}

a{
    color: black;
    margin-top: 5px;
    /* text-decoration: none; */
    font-size: 20px;
}
a:hover{
    color: red;
}

    </style>
</head>
<body>

    <!-- Signup Form Modal -->

    <div class="signup-modal">
        <div class="modal-content">
            <h2>Sign Up</h2>
            <form action="signup.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="your@email.com" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Choose a username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="signup-btn">Sign Up</button>
            </form>
            <p>Already have an account? <a href="login.php">Log In</a></p>
            <a href="../index.php">Back to home</a>
        </div>
    </div>
</body>
</html>
