<html>
<head>
<title> Non-Seamless-kit</title>
</head>
<body>

<center>

<?php include('Crypto.php') ?>
<?php include('db.php') ?>
<?php 
	
	error_reporting(0);
	
	$merchant_data='';
	$access_code='AVCX73EJ71BC14XCCB';//Shared by CCAVENUES
	$working_key='B4BFF648CB54187421CF45AC0A5E20FD';//Shared by CCAVENUES
	
	if(
		!isset($_POST['merchant_param1']) || 
		empty($_POST['merchant_param1']) || 
		((!isset($_POST['merchant_param2']) || 
		empty($_POST['merchant_param2'])) &&
		(!isset($_POST['merchant_param3']) || 
		empty($_POST['merchant_param3'])))
	){
		die('User, Subscription Plan & Transaction Id can not be empty.');
	}
	
	$user_id = $_POST['merchant_param1'];
	$sub_id = $_POST['merchant_param2'];
	$trans_id = $_POST['merchant_param3'];
	$module = $_POST['merchant_param4'];
	$rate = 0;

	if($sub_id!=0){
		$query = "select * from subscription where id = '$sub_id' and module = '$module' limit 1";
		$result = mysqli_query($conn,$query);
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$rate = $row["yearly_package"];			
			}
		} else {
			$rate="43200";
		}
	} else {
		$query = "select * from user_payment_details where id = '$trans_id' limit 1";
		$result = mysqli_query($conn,$query);
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$rate = $row["transaction_amount"];			
			}
		} else {
			$rate="43200";
		}
	}
	
	$_POST['amount'] = $rate;

	$query = "select * from group_users where gu_id = '$user_id' limit 1";
	$result = mysqli_query($conn,$query);
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$_POST['billing_name'] = $row['name'];
			$_POST['billing_tel'] = $row['gu_mobile'];
			$_POST['billing_email'] = $row['gu_email'];
		}
	} else {
		$_POST['billing_name'] = $_POST['name'];
		$_POST['billing_email'] = $_POST['email'];
		$_POST['billing_tel'] = $_POST['phone'];
	}

	foreach ($_POST as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}

	if($merchant_data!=''){
		$merchant_data = substr($merchant_data, 0, strlen($merchant_data)-1);
	}

	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.
?>

<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
echo '<input type="hidden" name="encRequest" value="'.$encrypted_data.'">';
echo '<input type="hidden" name="access_code" value="'.$access_code.'">';
?>
</form>
</center>
<script language='javascript'>
	document.redirect.submit();
</script>
</body>
</html>