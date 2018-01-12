<?php 

$name=$_POST["name"];
$email=$_POST["email"];
$phone=$_POST["phone"];
$company=$_POST["company"];
$city=$_POST["city"];
$message=$_POST["message"];

$to = "info@pecanreams.com";
$subject = "Enquiry from Pecan REAMS Website";
$txt = "Hi, <br><br>Please find below the enquiry from Pecan REAMS website: <br><br>Name: ".$name."<br>Email: ".$email."<br>Phone: ".$phone."<br>Company: ".$company."<br>City: ".$city."<br>Message: ".$message."<br><br>Regards,<br>Team Pecan REAMS";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <info@pecanreams.com>' . "\r\n";

mail($to,$subject,$txt,$headers);

echo "<script>alert('Your Enquiry has been received. Our Team will get back to you shortly...');window.open('index.html#map','_self','true');</script>"

?>