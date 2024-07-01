<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Input validation
if(trim($_POST['name']) == '') {
    echo 'You must enter your name.';
    exit();
} else if(trim($_POST['email']) == '') {
    echo 'You must enter an email address.';
    exit();
} else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo 'You must enter a valid email address.';
    exit();
} else if(trim($_POST['phone']) == '') {
    echo 'Please fill all fields!';
    exit();
} else if(trim($_POST['comments']) == '') {
    echo 'You must enter your query';
    exit();
}

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$comments = stripslashes($_POST['comments']);

// Email configuration
$address = "info@tllgt.com";
$e_subject = 'Contact Form';
$e_body = "You have been contacted by $name, their additional message is as follows." . PHP_EOL . PHP_EOL;
$e_content = "\"$comments\"" . PHP_EOL . PHP_EOL;
$e_reply = "You can contact $name via email, $email or Mobile Number $phone";

// Prepare email
$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'info@tllgt.com';
    $mail->Password = '1@INFO971#TLLgt';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;
    //Recipients
    $mail->setFrom('info@tllgt.com', 'Contact Form');
    $mail->addReplyTo($email, $name); // Add a reply-to address
    $mail->addAddress($address);

    //Content
    $mail->isHTML(false);
    $mail->Subject = $e_subject;
    $mail->Body    = wordwrap($e_body . $e_content . $e_reply, 70);

    $mail->send();
    echo 'Email Sent Successfully.';
    echo "Thank you $name, your message has been submitted to us.";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
