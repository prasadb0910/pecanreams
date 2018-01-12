<?php include('Crypto.php') ?>
<?php include('db.php') ?>
<?php

	// error_reporting(0);
	
	$workingKey='B4BFF648CB54187421CF45AC0A5E20FD';		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);

	$dataSize=sizeof($decryptValues);
	
	$rest = array();
	for($i = 0; $i < $dataSize; $i++){
		$information=explode('=',$decryptValues[$i]);
		$rest[$information[0]] = $information[1];
		if($i==3){	
			$order_status=$information[1];
		}
	}

	$response_message="";
	
	if($order_status==="Success"){
		$response_message= "Congratulations…, Thanks for the payment….";
	} else if ($order_status==="Aborted"){
		$response_message= "Oops…Payment Failed…, Please try again";
	} else if ($order_status==="Failure"){
		$response_message= "Oops…Payment Failed…, Please try again";
	} else {
		$response_message= "Security Error. Illegal access detected";
	}
	
	if(!empty($rest)){		
		$user_id = $rest['merchant_param1'];
		$sub_id = $rest['merchant_param2'];
		$trans_id = $rest['merchant_param3'];
		$order_num = $rest['order_id'];
		$ccavenue_ref = $rest['tracking_id'];
		$amount = $rest['amount'];
		$status = $order_status;
		$order_date = date("Y-m-d H:i:s");
		$pay_mode = $rest['payment_mode'];
		$result_data = ($rcvdString);

		$start_date = date('Y-m-d');
		$end_date = date("Y-m-d",strtotime('+12 month'));
		
		$sql = "insert into payment_transactions set 
					user_id='$user_id',
					sub_id='$sub_id',
					trans_id='$trans_id',
					sub_start_date='$start_date',
					sub_end_date='$end_date',
					order_num='$order_num',
					ccavenue_ref='$ccavenue_ref',
					amount='$amount',
					status='$status',
					order_date='$order_date',
					pay_mode='$pay_mode',
					result_data='$result_data',
					created='$order_date',
					modified='$order_date'
				";
		mysqli_query($conn,$sql);
		if($order_status==="Success"){
			// $query = "select * from users where id = '$user_id' limit 1";
			// $result = mysql_query($query);

			// if (mysql_num_rows($result) > 0) {
			// 	while ($row = mysql_fetch_assoc($result)) {
			// 		echo '';
			// 		file_get_contents("http://www.mydietist.com/Mailapp/send_mails/$user_id/$sub_id");
			// 		sleep(2);
			// 	}
			// }
			
			// $getcode="select offer_code from nearbuy_user_info where id='$user_id'";
			// $row = mysql_fetch_assoc($getcode);
			// $offer_code  = $row['offer_code'];
			// if($offer_code!="") {
			// 	$updatenearbuyoffer = "update nearbuy_offer_codes set status='Redeemed' where offer_code='$offer_code'";
			// 	mysql_query($updatenearbuyoffer);
			// }
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome To Pecan Reams</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="stylesheet" href="ccv/css/style.css"> -->
	<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','//connect.facebook.net/en_US/fbevents.js');

fbq('init', '1739458019616984');
fbq('track', "PageView");
fbq('track', 'Purchase', {value: '1.00', currency: 'USD'});
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1739458019616984&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
</head>
<body>
	<div class="headerBlock">
		<div class="logo"><a href="#">&nbsp;</a></div>
	</div>
	<div class="payment-popup">
		<br>
		<p><?php echo $response_message; ?></p>
		<a class="payment-btn blue_btn " href="#">Close</a>
	</div>
	<div class="overflow-screen"></div>	

	<script>
		// window.location = "http://localhost/d3m/public/index.php/user_payment_detail/payment_response/<?php echo $response_message; ?>/<?php echo $order_status; ?>";
		// window.location = "http://ec2-52-221-239-38.ap-southeast-1.compute.amazonaws.com/public_notices/public/index.php/user_payment_detail/payment_response/<?php echo $response_message; ?>/<?php echo $order_status; ?>";
		// window.location = "http://www.pecanreams.com/d3m/public/index.php/user_payment_detail/payment_response/<?php echo $response_message; ?>/<?php echo $order_status; ?>";
		window.location = "<?php echo $base_url; ?>d3m/public/index.php/user_payment_detail/payment_response/<?php echo $response_message; ?>/<?php echo $order_status; ?>";
	</script>
	</body>	
</html>