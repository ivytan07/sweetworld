<?php
error_reporting(0);
include_once ("dbconnect.php");
$name = $_GET['name'];
$email = $_GET['email'];
$mobile = $_GET['phoneno'];
$amount = $_GET['price'];
$address = $_GET["homeaddress"];

$data = array(
    'id' => $_GET['billplz']['id'],
    'paid_at' => $_GET['billplz']['paid_at'],
    'paid' => $_GET['billplz']['paid'],
    'x_signature' => $_GET['billplz']['x_signature']
);

$paidstatus = $_GET['billplz']['paid'];

if ($paidstatus == "true")
{
    $receiptid = $_GET['billplz']['id'];
    $signing = '';
    foreach ($data as $key => $value)
    {
        $signing .= 'billplz' . $key . $value;
        if ($key === 'paid')
        {
            break;
        }
        else
        {
            $signing .= '|';
        }
    }

    $signed = hash_hmac('sha256', $signing, 'S-wzNn8FTL0endIB4wgi728w');
    if ($signed === $data['x_signature'])
    {

    }

    $sqlinsertpurchased = "INSERT INTO tbl_payments(receiptid,name,email,phoneno,homeaddress,paid,status) VALUES('$receiptid','$name','$email','$mobile','$address', '$amount','paid')";
    $stmt = $conn->prepare($sqlinsertpurchased);
    $stmt->execute();
    $sqldeletecart = "DELETE FROM tbl_carts WHERE email='$email'";
    $stmt = $conn->prepare($sqldeletecart);
    $stmt->execute();

    echo '<br><br><body><div><h2><br><br><center>Your Receipt</center>
     </h1>
     <table border=1 width=70% height=50% align=center>
     <tr><td>Receipt ID</td><td>' . $receiptid . '</td></tr><tr><td>Email to </td>
     <td>' . $email . ' </td></tr><td>Amount </td><td>RM ' . $amount . '</td></tr>
     <tr><td>Payment Status </td><td>' . $paidstatus . '</td></tr>
     <tr><td>Date </td><td>' . date("d/m/Y") . '</td></tr>
     <tr><td>Time </td><td>' . date("h:i a") . '</td></tr>
     </table><br>
     <p style="text-align:center">
     <a  href=' . 'https://mywonderworlds.com/Tan_Ivy/sweetworld/php/index.php' . '>Press this link to return to Sweet World </a>
     </p>';
}
else
{
    echo "<script>alert('Payment Failed')</script>";
    echo "<script>window.location.replace('cart.php')</script>";
}
?>
