<?php 
	// require 'TesseractOCR.php';
	// echo "Test OCR";
	// echo "<br/>";
	// // echo (new TesseractOCR('images/text.jpeg'))->run();
	
	// echo (new TesseractOCR('test.png'))->run();


	// $criteria1 = preg_replace('/[^A-Za-z0-9]/', '', 'Omsai technology');
	// $criteria2 = preg_replace('/[^A-Za-z0-9]/', '', 'Harwardhan Agarwal');

	// $bl_criteria = false;

 //    if(stripos($criteria1, $criteria2)!==false || stripos($criteria2, $criteria1)!==false){
 //        $bl_criteria = true;
 //        goto Label1;
 //    }
 //    if(is_numeric($criteria1)==false && is_numeric($criteria2)==false){
 //        if(metaphone($criteria1)==metaphone($criteria2) || soundex($criteria1)==soundex($criteria2)){
 //            $bl_criteria = true;
 //            goto Label1;
 //        }
 //    }

 //    $i = 0;
 //    $substr = substr($criteria1, $i, 5);
 //    while (strlen($substr)>=5) {
 //        if(stripos($criteria2, $substr)!==false){
 //            $bl_criteria = true;
 //            goto Label1;
 //        }
 //        $i = $i + 1;
 //        $substr = substr($criteria1, $i, 5);
 //    }

 //    $i = 0;
 //    $substr = substr($criteria2, $i, 5);
 //    while (strlen($substr)>=5) {
 //        if(stripos($criteria1, $substr)!==false){
 //            $bl_criteria = true;
 //            goto Label1;
 //        }
 //        $i = $i + 1;
 //        $substr = substr($criteria2, $i, 5);
 //    }

 //    $i = 0;
 //    $substr1 = substr($criteria1, $i, 5);
 //    $substr2 = substr($criteria2, $i, 5);
 //    while (strlen($substr1)>=5 && strlen($substr2)>=5) {
 //        if(is_numeric($substr1)==false && is_numeric($substr2)==false){
 //            if(metaphone($substr1)==metaphone($substr2) || soundex($substr1)==soundex($substr2)){
 //            	echo $substr1;
 //            	echo '<br/>';
 //            	echo $substr2;
 //            	echo '<br/>';
 //                $bl_criteria = true;
 //                goto Label1;
 //            }
 //        }

 //        $i = $i + 1;
 //        $substr1 = substr($criteria1, $i, 5);
 //        $substr2 = substr($criteria2, $i, 5);
 //    }

 //    Label1:

 //    echo ($bl_criteria==true)?'True':'False';


$criteria1 = preg_replace('/[^A-Za-z0-9]/', '', '2/3');
$criteria2 = preg_replace('/[^A-Za-z0-9]/', '', '526/pt, 72/7(pt), 72/8(pt), 72/9(pt), 74(pt), 75/1, 75/2, 76');


$bl_criteria = false;

$check_arr1 = preg_replace('/[^A-Za-z0-9]/', '', $criteria1);
$check_arr2 = preg_replace('/[^A-Za-z0-9]/', '', $criteria2);

if(stripos($check_arr1, $check_arr2)!==false || stripos($check_arr2, $check_arr1)!==false){
    $bl_criteria = true;
    goto Label1;
}

$check_arr1 = preg_replace('/[^A-Za-z0-9\,]/', '', $criteria1);
$check_arr2 = preg_replace('/[^A-Za-z0-9\,]/', '', $criteria2);

$check_arr = explode(',', $check_arr1);
foreach ($check_arr as $check_val) {
    if(isset($check_val) && $check_val!=''){
        if(stripos($check_arr2, $check_val)!==false){
            $bl_criteria = true;
            goto Label1;
        }
    }
}

$check_arr = explode(',', $check_arr2);
foreach ($check_arr as $check_val) {
    if(isset($check_val) && $check_val!=''){
        if(stripos($check_arr1, $check_val)!==false){
            $bl_criteria = true;
            goto Label1;
        }
    }
}

Label1:

echo ($bl_criteria==true)?'True':'False';


?>