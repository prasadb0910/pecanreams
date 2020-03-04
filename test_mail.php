<?php
require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
// try {
//Server settings
$mail->SMTPDebug = 0;                                 // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'ssl://smtp.googlemail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'emailid';                 // SMTP username
$mail->Password = 'password';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

//Recipients
$mail->setFrom('technology@otbconsulting.co.in', 'OTB Innovtech');
// $mail->addAddress($email, $name);     // Add a recipient
$mail->addAddress('prasad.bhisale@otbconsulting.co.in', 'Prasad');
// $mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('technology@otbconsulting.co.in', 'OTB Innovtech');
// $mail->addCC('ashwini.patil@pecanreams.com');
// $mail->addBCC('bcc@example.com');

//Attachments
// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

//Content
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'Welcome to Pecan Reams';
$mail->Body = '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                </head>
                <body>
                    <div class="container">
                        <p>Hi Prasad,</p>
                        <p>
                            Thank you for registering with Pecan Reams.
                        </p>
                        <br>
                        For any specific information, general feedback about the site or content, please feel free to write on info@pecanreams.com
                        <br><br><br>
                        Thanks,<br><br>
                        Team Pecan Reams
                    </div>
                </body>
                </html>';
$mail->AltBody = 'Thank you for registering with Pecan Reams.';

$mail->send();
?>