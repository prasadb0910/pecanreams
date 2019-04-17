<?php
$host = 'localhost';
$user = 'root';
//$pass = '';
$pass = 'pecan@12345';
// $database = 'property_schema';
$database = 'prop_details';

$conn = mysqli_connect($host, $user, $pass, $database);
// $conn2 = mysqli_connect($host, $user, $pass, $database2);

// $conn = new mysqli($host, $user, $pass, $database);


// if (!$conn || !$conn2) {
//     echo "Unable to connect to DB: " . mysql_error();
//     exit;
// }


if (!$conn) {
    echo "Unable to connect to DB: " . mysql_error();
    exit;
}

// if (!mysql_select_db($database)) {
//     echo "Unable to select mydbname: " . mysql_error();
//     exit;
// }

$base_url = 'https://www.pecanreams.com';

?>