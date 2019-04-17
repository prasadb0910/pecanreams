<?php 
include('../db.php');

$user_id = '338';
$email_id = 'prasad.bhisale@pecanreams.com';
$token = rand(100000,999999);
$token = md5($token);

$sql = "Insert into user_login_emails (user_id, email, token, isVerified) values ('$user_id', '$email_id', '$token', '0')";
mysqli_query($conn, $sql);

// $url =  'https://www.pecanreams.com/app/index.php/login/get_laravel_session/'.$token;
$url =  'http://localhost/pecanreams/app/index.php/login/get_laravel_session/'.$token;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Test Pecan Reams</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div class="headerBlock">
		<div class="logo"><a href="#">&nbsp;</a></div>
	</div>
	<div class="payment-popup">
		<a class="payment-btn blue_btn " href="#">Close</a>
	</div>
	<div class="overflow-screen"><?php $url; ?></div>	

	<script>
		window.onload = function(){
			window.location = "<?php echo $url; ?>";
		}
	</script>
</body>	
</html>