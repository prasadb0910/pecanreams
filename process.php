<?php 
require 'PHPMailerAutoload.php';
// include('db/connection.php');
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $database = 'eat_erp';
		
		/* $host = 'localhost';
        $user = 'eatangcp_root';
        $password = 'EatErp@12345#';
        $database = 'eatangcp_eat_erp';*/
		
		$conn = mysql_connect($host, $user, $password) or die('Error: Could not connect to database - ' . mysql_error());
        // Once connected, we can select a database
        mysql_select_db($database, $conn) or die('Error in selecting the database: ' . mysql_error());
		
if (isset($_POST['submit'])) {

	$email=$_POST['email'];
	
	// prepare and bind
	$sql="INSERT INTO user_website (email,inserted_date) VALUES ('".$email."',now())";
	mysql_query($sql);
	// echo $result;
	// echo $sql;
}
//$to      = 'cs@eatanytime.in';
$mail = new PHPMailer;

$mail->SMTPDebug = 3;                               // Enable verbose debug output

// $mail->isSMTP();                                      // Set mailer to use SMTP
// $mail->Host = 'ssl://smtp.googlemail.com';  // Specify main and backup SMTP servers
// $mail->SMTPAuth = true;                               // Enable SMTP authentication
// $mail->Username = 'info@pecanreams.com';                 // SMTP username
// $mail->Password = 'ASSURE789';                           // SMTP password
// $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
// $mail->Port = 465;                                    // TCP port to connect to

// $mail->setFrom('info@pecanreams.com', 'Pecan');
// $mail->addAddress('prasad.bhisale@pecanreams.com', 'Prasad');     // Add a recipient
// // $mail->addAddress('ellen@example.com');               // Name is optional
// $mail->addReplyTo('info@pecanreams.com', 'Information');
// // $mail->addCC('cc@example.com');
// // $mail->addBCC('bcc@example.com');


$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'mail.eatanytime.co.in';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'cs@eatanytime.co.in';                 // SMTP username
$mail->Password = 'Customer@12345';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('ashwinipatil1906@gmail.com', 'Wholesome');
$mail->addAddress('ashwini.patil@pecanreams.com', 'Prasad');     // Add a recipient $mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('ashwinipatil1906@gmail.com', 'Information');
// $mail->addCC('cc@example.com');
// $mail->addBCC('bcc@example.com');


// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
 $mail->Subject = 'Enquiry From Website';
    $mail->Body    = 'Hi,<br><br>Please find below the details of enquiry<br><br>Email: '.$email.'<br>Regards,<br>Team Eatanytime';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
	header('Location: ../index.php?subscribe_success=1');
	
	
	
	



 ?>