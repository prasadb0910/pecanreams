<html>
<body><h2>Hi {{ $name }},</h2>
	<p>
		This is to inform you that we have identified a public notice on your said asset. Below are the details of the same. 
		Also we have attached public notice for your reference
	</p>
	<br><br>
	<table border="1" style="border-collapse:collapse;">
		<tr>
			<th>Particulars</th>
			<th>Details</th>
		</tr>
		<tr>
			<td>Date of notice: </td>
			<td>{{ $date_of_notice }}</td>
		</tr>
		<tr>
			<td>Property Name:</td>
			<td>{{ $property_name }}</td>
		</tr>
		<tr>
			<td>Address:</td>
			<td>{{ $address }}</td>
		</tr>
		<tr>
			<td>Newspaper:</td>
			<td>{{ $paper_name }}</td>
		</tr>
		<tr>
			<td>Link:</td>
			<td>{{ $link }}</td>
		</tr>
	</table>
	<br><br>
	Please note this is an approximate match which has been computed by our system. 
	And hence we are not responsible for the authenticity of the notices matched.
	<br><br>
	Thanks,<br>
	Team Pecan REAMS
</body>
</html>