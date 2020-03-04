<?php
    $result = 0;

    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
    {
        $result = 0;
        $secret = '6LdkqVMUAAAAAIcetIh8GRRJAt5C74a3OPJbz4oO';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success)
        {
            $succMsg = 'Your contact request have submitted successfully.';
            $result = 1;
        }
        else
        {
            $errMsg = 'Robot verification failed, please try again.';
            $result = 0;
        }
    }

    echo $result;
?>