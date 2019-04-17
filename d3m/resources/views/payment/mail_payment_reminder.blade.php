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
		Hi {{ $name }},
		<p style="line-height: 2;">
			We are writing to you to let you know that we have not yet received the following payment.
			<br>
			Statement Period: {{ $start_date }} to {{ $end_date }}
			<br>
			Invoice Number: {{ $invoice_no }}
			<br>
			Amount: {{ $total_amount }}
			<br><br>
			Following is the link to access your invoice.
			<br>
			{{url('index.php/user_payment_detail/get_invoice/'.$user_id)}}
			<br><br>
			Following is the link to make payment.
			<br>
			{{url('../../dataFrom.php?user_id='.$user_id.'&sub_id=0&trans_id='.$id.'&module=Assure')}}
			<br><br>
			You can also Login to https://www.pecanreams.com/app to make payment online or for offline call us at +91 22 6143 1777.
			<br><br>
			Request you to make timely payments to avoid suspension of services.
			<br><br>
			In case of any queries write to us on info@pecanreams.com
			<br><br>
		</p>
		<br><br>
		Regards,<br><br>
		Team Pecan REAMS
	</div>
</body>
</html>