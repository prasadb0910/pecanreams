<html>
<body><h2>Hi {{ $name }},</h2>
	<p>
		This is to inform you that a public notice has been published on your said asset. Below are the details of the same. 
		Also we have attached public notice for your reference
	</p>
	<br><br>
	<table border="1" style=" border-collapse:collapse;">
		<tr>
			<th style="background-color:#90EE90">Particulars</th>
			<th style="background-color:#90EE90">Details</th>
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
	Thanks,<br>
	{{ $name }}
</body>
</html>