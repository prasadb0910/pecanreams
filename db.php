<?php
$host = 'localhost';
$user = 'root';
$pass = '';
// $pass = 'Pecan@12345';
$database = 'property_schema';
// $database2 = 'prop_details';

// $host = '52.77.255.84';
// $user = 'root';
// $pass = 'Pecan@12345';
// $database = 'public_notices';

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


// output: /myproject/index.php
$currentPath = $_SERVER['PHP_SELF']; 

// output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
$pathInfo = pathinfo($currentPath); 

// output: localhost
$hostName = $_SERVER['HTTP_HOST']; 

// output: http://
$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';

// return: http://localhost/myproject/
// $base_url = $protocol.$hostName.$pathInfo['dirname']."/";
$base_url = $protocol.$hostName.$pathInfo['dirname'];

?>