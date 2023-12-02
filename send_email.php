<?php
require 'vendor/autoload.php';
require 'config.php';

$user_first_name = isset($_POST['user_first_name']) ? $_POST['user_first_name'] : '';
$user_last_name = isset($_POST['user_last_name']) ? $_POST['user_last_name'] : '';
$user_email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
$confirm_user_email = isset($_POST['confirm_user_email']) ? $_POST['confirm_user_email'] : '';
$email_subject = isset($_POST['email_subject']) ? $_POST['email_subject'] : '';
$email_body = isset($_POST['email_body']) ? $_POST['email_body'] : '';

if (empty($user_first_name) || empty($user_last_name) || empty($user_email) || empty($confirm_user_email) || empty($email_subject) || empty($email_body)) {
    die('Error: Please fill out all required fields.');
}

function send_email($user_first_name, $user_last_name, $user_email, $confirm_user_email, $email_subject, $email_body) {
    global $sender_email, $sender_password, $smtp_server, $smtp_port;

    // Create a PHPMailer object
    $mail = new \PHPMailer\PHPMailer\PHPMailer();

    try {
        // Configure the SMTP settings
        $mail->isSMTP();
        $mail->Host = $smtp_server;
        $mail->Port = $smtp_port;
        $mail->SMTPAuth = true;
        $mail->Username = $sender_email;
        $mail->Password = $sender_password;
        $mail->SMTPSecure = 'tls';

        // Set the email content
        $mail->setFrom($sender_email, $user_first_name . ' ' . $user_last_name);
        $mail->addAddress($sender_email);
        $mail->Subject = $email_subject;
        $mail->addReplyTo($user_email, $user_first_name . ' ' . $user_last_name); // Set the "Reply-To" address to the user's email and name

        // Include user's email in the email body
        $mail->Body = "User's Name: $user_first_name $user_last_name\nUser's Email: $user_email\n\n" . $email_body;

        // Add custom header for "From" name
        $mail->addCustomHeader('From: ' . $user_first_name . ' ' . $user_last_name . ' <' . $user_email . '>');

        // Send the email
        if ($mail->send()) {
            echo 'Email sent successfully, thank you. If you need to contact me immediately, my number is 509-273-0050.';
        } else {
            echo 'Error sending email: ' . $mail->ErrorInfo;
            return;
        }
    } catch (Exception $e) {
        echo 'Error sending email: ' . $e->getMessage();
    }
}

// Call the function to send the email
send_email($user_first_name, $user_last_name, $user_email, $confirm_user_email, $email_subject, $email_body);
?>
