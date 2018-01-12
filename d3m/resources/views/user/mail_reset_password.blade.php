<!-- <html>
<body><h2>Hello!</h2>
	<p>
		You are receiving this email because we received a password reset request for your account.
	</p>
	<br><br>
		<a href="{{--url('index.php/password/reset/'.$token)--}}">Test</a>
	<br><br>
	If you did not request a password reset, no further action is required.
	<br><br>
	Thanks,<br>
	Team Pecan REAMS
</body>
</html> -->

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
		Hello!
		<p>
			You are receiving this email because we received a password reset request for your account.
		</p>
		<br><br>

		<table width="200" height="44" cellpadding="0" cellspacing="0" border="0" bgcolor="#41a541" style="border-collapse:collapse!important;border-radius:4px">
			<tbody>
				<tr>
					<td align="center" valign="middle" height="44" style="font-family:'Open Sans',sans-serif;font-size:14px;font-weight:normal">
						<a  href="{{url('index.php/password/reset/'.$token)}}"style="font-family:'Open Sans',sans-serif;color:#ffffff;display:inline-block;text-decoration:none;line-height:44px;width:200px;font-weight:normal;text-transform:uppercase" >Reset Password </a>
					</td>
				</tr>
			</tbody>
		</table>

		<br><br>
		If you did not request a password reset, no further action is required.
		<br><br>
		Thanks,<br>
		Team Pecan REAMS
	</div>

</body>
</html>