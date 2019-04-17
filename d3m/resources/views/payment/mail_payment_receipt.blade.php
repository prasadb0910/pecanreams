<!DOCTYPE html>
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
		Dear {{ $name }},
		<p style="line-height: 2;">
			We are in receipt of your payment of Rs. {{ $transaction_amount }}. 
			@if(isset($total_outstanding))
			Current Outstanding is Rs. {{ $total_outstanding }}.
			@endif
			<br><br>
			In case of any queries write to us on info@pecanreams.com 
		</p>
		<br><br>
		Regards,<br><br>
		Team Pecan Reams
	</div>
</body>
</html>