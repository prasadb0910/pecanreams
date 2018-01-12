<?php 
	// require 'TesseractOCR.php';
	// echo "Test OCR";
	// echo "<br/>";
	// // echo (new TesseractOCR('images/text.jpeg'))->run();
	
	// echo (new TesseractOCR('test.png'))->run();


   $substr1 = "Hello";
   $substr2 = substr($substr1, 8, 10);

   echo $substr2;

   echo '<br/>';
   echo '<br/>';


   $string = 'a|-"bc!,@£d-e^&$f, g';
   echo preg_replace('/[^A-Za-z0-9\,]/', '', $string);

	
	$string = 'a|"bc!@£de^&$f g';
	// $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   	echo preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   	echo '<br/>';
   	echo '<br/>';

   	echo is_numeric('assistants')?'True':'false';
   	echo '<br/>';
   	echo metaphone('assistants');
   	echo '<br/>';
   	echo metaphone('assistance');
   	echo '<br/>';
   	echo soundex('assistants');
   	echo '<br/>';
   	echo soundex('assistance');
   	echo '<br/>';
   	echo '<br/>';


   	echo is_numeric('phase125')?'True':'false';
   	echo '<br/>';
   	echo metaphone('phase125');
   	echo '<br/>';
   	echo metaphone('phase126');
   	echo '<br/>';
   	echo soundex('phase125');
   	echo '<br/>';
   	echo soundex('phase126');
   	echo '<br/>';
   	echo '<br/>';


   	echo is_numeric('125ddgh55')?'True':'false';
   	echo '<br/>';
   	echo metaphone('125ddgh55');
   	echo '<br/>';
   	echo metaphone('126ddgh66');
   	echo '<br/>';
   	echo soundex('125ddgh55');
   	echo '<br/>';
   	echo soundex('126ddgh66');
   	echo '<br/>';
   	echo '<br/>';


   	echo is_numeric('12555')?'True':'false';
   	echo '<br/>';
   	echo metaphone('12555');
   	echo '<br/>';
   	echo metaphone('12666');
   	echo '<br/>';
   	echo soundex('12555');
   	echo '<br/>';
   	echo soundex('12666');
   	echo '<br/>';
   	echo '<br/>';


	echo metaphone('i can not do it');
   	echo '<br/>';
   	echo metaphone('not do');
   	echo '<br/>';
   	echo soundex('i can not do it');
   	echo '<br/>';
   	echo soundex('not do');
   	echo '<br/>';
   	echo '<br/>';


	echo metaphone('icannotdoit');
   	echo '<br/>';
   	echo metaphone('notdo');
   	echo '<br/>';
   	echo soundex('icannotdoit');
   	echo '<br/>';
   	echo soundex('notdo');
   	echo '<br/>';
   	echo '<br/>';


   	echo 'Finish';
   	echo '<br/>';
   	echo '<br/>';


   	echo stripos('answrer','q')!==false?'True':'false';
?>