<?php
// Get the checksum
function getchecksum($MerchantId,$Amount,$OrderId ,$URL,$WorkingKey)
{
	$str ="$MerchantId|$OrderId|$Amount|$URL|$WorkingKey";
	$adler = 1;
	$adler = adler32($adler,$str);
	return $adler;
}
?>
<?php
//Verify the the checksum
function verifychecksum($MerchantId,$OrderId,$Amount,$AuthDesc,$CheckSum,$WorkingKey)
{
	$str = "$MerchantId|$OrderId|$Amount|$AuthDesc|$WorkingKey";
	$adler = 1;
	$adler = adler32($adler,$str);
	if($adler == $CheckSum)
	return "true";
	else
	return "false" ;
}
?>
<?php
function leftshift($str , $num) {
	$str = DecBin($str);
	for( $i = 0 ; $i < (64 – strlen($str)) ; $i++)
		$str = "0".$str ;
	for($i = 0 ; $i < $num ; $i++) {
		$str = $str."0";
		$str = substr($str , 1 ) ;
	}
	return cdec($str) ;
}
?>
<?php
function cdec($num) {
	for ($n = 0 ; $n < strlen($num) ; $n++) {
		$temp = $num[$n] ;
		$dec = $dec + $temp*pow(2 , strlen($num) – $n – 1);
	}
	return $dec;
}
?>
<?php
function adler32($adler , $str) {
	$BASE = 65521 ;
	$s1 = $adler & 0xffff ;
	$s2 = ($adler >> 16) & 0xffff;
	for($i = 0 ; $i < strlen($str) ; $i++) {
		$s1 = ($s1 + Ord($str[$i])) % $BASE ;
		$s2 = ($s2 + $s1) % $BASE ;
	}
	return leftshift($s2 , 16) + $s1;
}
?>

<?php
	// Merchant id provided by CCAvenue
	$Merchant_Id = "151492";
	// Item amount for which transaction perform
	$Amount = "100";
	// Unique OrderId that should be passed to payment gateway
	$Order_Id = "006789";
	// Unique Key provided by CCAvenue
	$WorkingKey= "B4BFF648CB54187421CF45AC0A5E20FD";
	// Success page URL
	$Redirect_Url="success.php";
	// $Checksum = getCheckSum($Merchant_Id,$Amount,$Order_Id ,$Redirect_Url,$WorkingKey);
?>

<?php 
echo 'Hiiiiiii'; 
echo $_Get['auth_status'];
// echo verifychecksum($MerchantId,$OrderId,$Amount,$AuthDesc,$CheckSum,$WorkingKey);
?>