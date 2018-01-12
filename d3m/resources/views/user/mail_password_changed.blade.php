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
		<p>
			This is to inform you that your password was reset on {{ $date }} at {{ $time }}.
			<br/>
			If you did this you can safely disregard this.
			<br/>
			If you didn’t do this, reach us on info@pecanreams.com.
		</p>
		<br><br>
		Regards,<br>
		Team Pecan REAMS
	</div>

</body>
</html>