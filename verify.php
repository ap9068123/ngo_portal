<?php

require('config.php');


session_start();

$conn = mysqli_connect('localhost', 'ap', '123456', 'ajay');

require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api($keyId, $keySecret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true)
{
    $razorpay_order_id = $_SESSION['razorpay_order_id'];
    $razorpay_payment_id = $_POST['razorpay_payment_id'];
    $email = $_SESSION['email'];
    $price = $_SESSION['price'];
    $sql = "INSERT INTO `donation` (`donation_id`, `razorpay_payment_id`, `status`, `email`, `price`) VALUES ('$razorpay_order_id', '$razorpay_payment_id', 'success', '$email', '$price')";
    
    if(mysqli_query($conn, $sql)){
        echo "";
    }



    $html = "<br><br><br><h1 style=\"color:green;text-align:center\">Your payment is successful</h1>
             <h2 style=\"color:green;text-align:center\">Payment ID: {$_POST['razorpay_payment_id']}</h2>";
}
else
{
    $html = "<h2 style=\"color:red;text-align:center\">Your payment failed</h2>
             <h2>{$error}</h2>";
}

echo $html;
