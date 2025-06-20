<?php
// app/Logic/contact_process.php
declare(strict_types=1);

// Initialize variables
$last_name = '';
$first_name = '';
$email = '';
$address = '';
$plz_ort = '';
$message = '';
$errormessage = '';
$successmessage = '';

// Only run on form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gather & sanitize
    $last_name = trim($_POST['last_name'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $plz_ort = trim($_POST['plz_ort'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate
    if (empty($last_name) || empty($first_name) || empty($email) || empty($message)) {
        $errormessage = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errormessage = 'Please enter a valid email address.';
    } else {
        // Prepare email
        $to = 'vanja.dunkel@gmail.com';
        $subject = "New contact from {$first_name} {$last_name}";
        $body = "Name: {$first_name} {$last_name}\n";
        $body .= "Email: {$email}\n";
        if ($address) $body .= "Address: {$address}\n";
        if ($plz_ort) $body .= "Postal/City: {$plz_ort}\n";
        $body .= "\nMessage:\n{$message}\n";

        $headers = "From: no-reply@yourdomain.com\r\n";
        $headers .= "Reply-To: {$email}\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Send
        if (mail($to, $subject, $body, $headers)) {
            $successmessage = 'Thank you for your message! I will get back to you soon.';
            // Clear form fields
            $last_name = $first_name = $email = $address = $plz_ort = $message = '';
        } else {
            $errormessage = 'Sorry, there was a problem sending your message. Please try again later.';
        }
    }
}
