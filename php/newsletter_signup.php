<?php
// newsletter_signup.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Connect to the database
        $conn = new mysqli('localhost', 'root', '', 'recipe_db');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if email is already subscribed
        $stmt = $conn->prepare("SELECT * FROM newsletter WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "You are already subscribed!";
        } else {
            // Insert the email into the database
            $stmt = $conn->prepare("INSERT INTO newsletter (email) VALUES (?)");
            $stmt->bind_param('s', $email);

            if ($stmt->execute()) {
                echo "Thank you for subscribing to our Cooking Contest Newsletter!";
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid email address. Please enter a valid email.";
    }
}
?>





<?php
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// require '../src/PHPMailer.php';
// require '../src/SMTP.php';
// require '../src/Exception.php';

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $email = $_POST['email'];

//     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         echo "<p style='color: red;'>Invalid email address.</p>";
//         exit;
//     }

//     $mail = new PHPMailer(true);

//     try {
//         $mail->isSMTP();
//         $mail->Host = 'smtp.gmail.com';
//         $mail->SMTPAuth = true;
//         $mail->Username = 'nizashaikh26@gmail.com';
//         $mail->Password = 'gayk ghsl haxi fhzm';
//         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//         $mail->Port = 587;

//         // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
//         // $mail->Port = 465;

//         $mail->setFrom('nizashaikh26@gmail.com', 'Tasty Tales');
//         $mail->addAddress($email);

//         $mail->isHTML(true);
//         $mail->Subject = 'Thank You for Subscribing to Tasty Tales!';
//         $mail->Body = "<h1>Welcome to Tasty Tales!</h1>
//                        <p>Thank you for subscribing to our newsletter. Stay tuned for amazing recipes, tips, and stories from our kitchen!</p>";
//         $mail->AltBody = 'Thank you for subscribing to our newsletter.';

//         $mail->SMTPDebug = 3; // Debugging
//         $mail->send();

//         echo "<p style='color: green;'>Thank you for subscribing! A confirmation email has been sent to your email address.</p>";
//     } catch (Exception $e) {
//         echo "<p style='color: red;'>Subscription failed. Please try again later.</p>";
//         echo "Error: " . $mail->ErrorInfo;
//     }
// }
?>



<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);


// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// // Include PHPMailer files
// // require '../src/PHPMailer/src/PHPMailer.php';
// // require '../src/PHPMailer/src/SMTP.php';
// // require '../src/PHPMailer/src/Exception.php';
// require '../src/PHPMailer.php';
// require '../src/SMTP.php';
// require '../src/Exception.php';


// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $email = $_POST['email'];

//     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         echo "<p style='color: red;'>Invalid email address.</p>";
//         exit;
//     }

//     // Send email
//     $mail = new PHPMailer(true);

//     try {
//         // Server settings
//         $mail->isSMTP();
//         $mail->Host = 'smtp.gmail.com'; // Replace with your email provider's SMTP server
//         $mail->SMTPAuth = true;
//         $mail->Username = 'nizashaikh26@gmail.com'; // Your email address
//         $mail->Password = 'gayk ghsl haxi fhzm';   // Your email password (App password if using Gmail)
//         $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
//         $mail->Port = 465;

//         // Recipients
//         $mail->setFrom('nizashaikh26@gmail.com', 'Tasty Tales'); // From email and name
//         $mail->addAddress($email); // User's email address

//         // Content
//         $mail->isHTML(true);
//         $mail->Subject = 'Thank You for Subscribing to Tasty Tales!';
//         $mail->Body = "<h1>Welcome to Tasty Tales!</h1>
//                        <p>Thank you for subscribing to our newsletter. We are thrilled to have you on board. Stay tuned for amazing recipes, tips, and stories from our kitchen!</p>
//                        <p>Happy Cooking,<br><strong>Tasty Tales Team</strong></p>";
//         $mail->AltBody = 'Thank you for subscribing to our newsletter. Stay tuned for amazing recipes, tips, and stories from our kitchen!';

//         $mail->send();

//         // Display success message on the webpage
//         echo "<p style='color: green;'>Thank you for subscribing! A confirmation email has been sent to your email address.</p>";
//     } catch (Exception $e) {
//         echo "<p style='color: red;'>Subscription failed. Please try again later.</p>";
//         echo "Mailer Error: " . $mail->ErrorInfo;
//     }
// }
// $mail->SMTPDebug = 3; // Use PHPMailer::DEBUG_SERVER for detailed debugging

// ?>


