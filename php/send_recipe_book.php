<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../src/PHPMailer.php';
require '../src/SMTP.php';
require '../src/Exception.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'nizashaikh26@gmail.com'; // Your email
    $mail->Password   = 'gayk ghsl haxi fhzm';     // Your App password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('nizashaikh26@gmail.com', 'Tasty Tales');
    
    // Get the email from the form submission
    $recipientEmail = $_POST['email'];
    $mail->addAddress($recipientEmail); // Use the email entered by the user

    $mail->isHTML(true);
    $mail->Subject = 'Your Recipe';
    $mail->Body    = 'Please find the recipe attached.';

    // Attach the text file
    $mail->addAttachment('../downloads/veggie-vegetarian-recipes-obooko.pdf'); // Update this path as needed

    $mail->send();
    echo 'Recipe sent successfully!';
} catch (Exception $e) {
    echo "Failed to send recipe. Mailer Error: {$mail->ErrorInfo}";
}
?>
