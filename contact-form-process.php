<?php
require_once('src/SMTP.php');
require_once('src/PHPMailer.php');
require_once('src/Exception.php');

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

$mail=new PHPMailer(true); // Passing `true` enables exceptions

try {
    //settings
    $mail->SMTPDebug=2; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host='smtp.gmail.com';
    $mail->SMTPAuth=true; // Enable SMTP authentication
    $mail->Username='michellevdwilligen@gmail.com'; // SMTP username
    $mail->Password='bestebeesje22'; // SMTP password
    $mail->SMTPSecure='ssl';
    $mail->Port=465;

    // validation expected data exists
    if (
        !isset($_POST['Name']) ||
        !isset($_POST['Email']) ||
        !isset($_POST['Message'])
    ) {
        problem('We are sorry, but there appears to be a problem with the form you submitted.');
    }

    //posts
    $name = $_POST['Name']; // required
    $email = $_POST['Email']; // required
    $message = $_POST['Message']; // required

    $mail->setFrom($email, $name);

    //recipient
    $mail->addAddress('michellevdwilligen@gmail.com', 'optional recipient name');     // Add a recipient

    //content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject='Je hebt een nieuwe mail ontvangen!';
    $mail->Body=$message;
    $mail->AltBody='This is the body in plain text for non-HTML mail clients';

    $mail->send();

    echo 'Message has been sent';
}
catch(Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: '.$mail->ErrorInfo;
}

?>
