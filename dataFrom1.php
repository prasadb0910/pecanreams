<?php include('db1.php') ?>

<!DOCTYPE html>
<html>

<head>
	<title>Welcome To Pecan Reams</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../ccv/css/style.css">
	<style>
		.loading-image{
			background-image: url("loading.gif");
			background-repeat: no-repeat;
			height: 128px;
			line-height: 128px !important;
			margin: auto !important;
			width: 128px;
		}
	</style>
</head>
<body>
<div class="headerBlock">
	<div class="logo"><a href="#">&nbsp;</a></div>
</div>
<div class="payment-popup">
<p class='loading-image'></p>
<p>You shall now be leaving Pecan Reams and will be taken to Ccavenues Payment Gateway</p>
<!-- <form method="post" id="customerData" name="customerData" action="http://localhost/pecanreams/ccavRequestHandler.php"> -->
<form method="post" id="customerData" name="customerData" action="https://www.pecanreams.com/demo/ccavRequestHandler1.php">
    <input type="hidden" name="tid" id="tid" readonly />
    <input type="hidden" name="order_id" id="order_id" readonly />
    <input type="hidden" name="merchant_id" value="151492"/>
    <input type="hidden" name="amount" value="1.00" id="amount"/>
    <input type="hidden" name="currency" value="INR"/>
    <!-- <input type="hidden" name="redirect_url" value="http://localhost/pecanreams/ccavResponseHandler.php"/>
    <input type="hidden" name="cancel_url" value="http://localhost/pecanreams/ccavResponseHandler.php"/> -->
    <input type="hidden" name="redirect_url" value="https://www.pecanreams.com/demo/ccavResponseHandler1.php"/>
    <input type="hidden" name="cancel_url" value="https://www.pecanreams.com/demo/ccavResponseHandler1.php"/>
    <input type="hidden" name="language" value="EN"/>		     	
    <input type="hidden" name="integration_type" value=""/>
	<!-- iframe_normal -->
	
	<input type="hidden" name="billing_name" value="Charli"/>
	<input type="hidden" name="billing_address" value=""/>
	<input type="hidden" name="billing_city" value=""/>
	<input type="hidden" name="billing_state" value="Maharashtra"/>
	<input type="hidden" name="billing_zip" value=""/>
	<input type="hidden" name="billing_country" value="India"/>
	<input type="hidden" name="billing_tel" value=""/>
	<input type="hidden" name="billing_email" value=""/>
	<input type="hidden" name="merchant_param1" id="merchant_param1" value=""/>
	<input type="hidden" name="merchant_param2" id="merchant_param2" value=""/>
	<input type="hidden" name="merchant_param3" id="merchant_param3" value=""/>
	<input type="hidden" name="merchant_param4" id="merchant_param4" value=""/>
	
	
	<!--INPUT TYPE="submit" class="payment-btn blue_btn " value="Make Payment" -->
</form>
</div>	
	<script>
		window.onload = function() {
			var d = new Date().getTime();
			document.getElementById("tid").value = d;
			document.getElementById("order_id").value = d;
		};
		
		var QueryString = function () {
			// This function is anonymous, is executed immediately and 
			// the return value is assigned to QueryString!
			var query_string = {};
			var query = window.location.search.substring(1);
			var vars = query.split("&");
			for (var i=0;i<vars.length;i++) {
				var pair = vars[i].split("=");
				// If first entry with this name
				if (typeof query_string[pair[0]] === "undefined") {
				  query_string[pair[0]] = pair[1];
					// If second entry with this name
				} 
				else if (typeof query_string[pair[0]] === "string") {
				  var arr = [ query_string[pair[0]], pair[1] ];
				  query_string[pair[0]] = arr;
					// If third or later entry with this name
				} 
				else {
				  query_string[pair[0]].push(pair[1]);
				}
			} 
			return query_string;
		} ();
		
		document.getElementById('merchant_param1').value = QueryString.user_id;
		document.getElementById('merchant_param2').value = QueryString.sub_id;
		document.getElementById('merchant_param3').value = QueryString.trans_id;
		document.getElementById('merchant_param4').value = QueryString.module;
		// document.getElementById('amount').value = QueryString.price;
		
		setTimeout(function(){
			document.forms['customerData'].submit();
		}, 5000);
	</script>
	</body>
</html>


