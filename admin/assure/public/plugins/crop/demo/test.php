<?php
	define('UPLOAD_DIR', 'uploads/');
	$image_parts = explode(";base64,", $_POST['imagedata']);
	$image_base64 = base64_decode($image_parts[1]);

	$file = UPLOAD_DIR . uniqid() . '.png';
	file_put_contents($file, $image_base64);