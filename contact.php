<?php
$name = escapeshellarg($_POST['Name']);
$email = escapeshellarg($_POST['Email']);
$messageText = escapeshellarg($_POST['Message']);

$to = "ytaylor003@gmail.com";  
$subject = "New Message from Website - " . date('Y-m-d H:i:s');

$message = "To: $to\n";
$message .= "Subject: $subject\n";
$message .= "From: $email\n";
$message .= "Reply-To: $email\n";
$message .= "Content-Type: text/plain; charset=utf-8\n\n";

$message .= "Name: $name\n";
$message .= "Email: $email\n";
$message .= "Message:\n$messageText\n";


// Dump the message into a temp file so msmtp can read it
$tmpFile = tempnam(sys_get_temp_dir(), 'mail_');
file_put_contents($tmpFile, $message);

$cmd = "msmtp -C /etc/msmtp/www-data.msmtprc -t < $tmpFile 2>&1";

$output = shell_exec($cmd);

file_put_contents("/tmp/mail_debug.log", $output, FILE_APPEND);

unlink($tmpFile);

header("Location: thankyou.html");
?>

