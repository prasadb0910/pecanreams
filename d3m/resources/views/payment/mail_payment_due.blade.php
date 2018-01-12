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
		<p>
			This is to inform you that your payment is due for the period {{ $start_date }} to {{ $end_date }}.
			<br>
			Following is the link to access your invoice.
			<br>
			{{url('index.php/user_payment_detail/get_invoice/'.$user_id)}}
			<br>
			Request you to make timely payments to avoid interest.
			<br><br>
			In case of any queries write to us on info@pecanreams.com 
			<br><br>
		</p>
		<br><br>
		Regards,<br>
		Team Pecan REAMS
	</div>
</body>
</html>