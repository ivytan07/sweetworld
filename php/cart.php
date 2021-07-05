<?php
session_start();
include_once ("dbconnect.php");
if (!isset($_COOKIE['email']))
{
    echo "<script>loadCookies()</script>";
}
else
{
    $email = $_COOKIE['email'];

    if (isset($_GET['deletebtn']))
    {
        $prid = $_GET['prid'];
        $sqldelete = "DELETE FROM tbl_carts WHERE id = '$prid ' AND email = '$email'";
        $stmt = $conn->prepare($sqldelete);

        if ($stmt->execute())
        {
            echo "<script> alert('Delete Successful')</script>";
            echo "<script>window.location.replace('cart.php')</script>";
        }
        else
        {
            echo "<script> alert('Delete Failed')</script>";
            echo "<script>window.location.replace('cart.php')</script>";

        }
    }
}

if (isset($_GET['paybtn']))
{
    $email = $_COOKIE['email'];
    $name = $_GET["name"];
    $mobile = $_GET["phoneno"];
    $address = $_GET["homeaddress"];
    $amount = $_GET['price'];

    $api_key = 'b7abc0fb-2167-465f-9b3e-ea9738535c46';
    $collection_id = 'x9bh1zne';
    $host = 'https://billplz-staging.herokuapp.com/api/v3/bills';

    $data = array(
        'collection_id' => $collection_id,
        'email' => $email,
        'mobile' => $mobile,
        'name' => $name,
        'amount' => $amount * 100, // RM20
        'description' => 'Payment for order',
        'callback_url' => "https://mywonderworlds.com/Tan_Ivy/sweetworld/php/index.php",
        'redirect_url' => "https://mywonderworlds.com/Tan_Ivy/sweetworld/php/paymentupdate.php?email=$email&name=$name&phoneno=$mobile&homeaddress=$address&price=$amount"

    );
    $process = curl_init($host);
    curl_setopt($process, CURLOPT_HEADER, 0);
    curl_setopt($process, CURLOPT_USERPWD, $api_key . ":");
    curl_setopt($process, CURLOPT_TIMEOUT, 30);
    curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($data));

    $return = curl_exec($process);
    curl_close($process);

    $bill = json_decode($return, true);

    //echo "<pre>".print_r($bill, true)."</pre>";
    header("Location: {$bill['url']}");

}

$sqlloadcart = "SELECT * FROM tbl_carts INNER JOIN tbl_products ON tbl_carts.id = tbl_products.id WHERE tbl_carts.email = '$email' ORDER BY tbl_carts.datecreated DESC";
$stmt = $conn->prepare($sqlloadcart);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Sweet World Enterprise</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <script src="../js/validate.js"></script>
      <link rel="stylesheet" href="../css/style.css">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   </head>
   <body>
      <div class="header">
         <img src="../uploads/logo1.png" align="left" hspace="50">
         <!--Logo-->
         <h1>Sweet World Enterprise</h1>
      </div>
      <div class="w3-bar w3-deep-purple w3-large">
         <!--Top navigation bar-->
         <a href="index.php" class="w3-bar-item w3-button"><i class="fa fa-navicon"></i> Product</a>
         <a href="cart.php" class="w3-bar-item w3-button"><i class="fa fa-shopping-cart" ></i> My Cart</a>
         <a href="homepage.php" class="w3-bar-item w3-button w3-right"><i class="fa fa-sign-out" ></i> Logout</a>
      </div>
      <div class="main">
      <div class="container">
      <center>
         <h2>My Cart</h2>
      </center>
    <?php
$totalsum = 0.0;
echo "<div class='container'>";
echo "<div class='card-row'>";
foreach ($rows as $products)
{
    $prid = $products['id'];
    $totalprice = 0.0;
    $totalprice = $products['prprice'] * $products['quantity'];
    echo "<div class='card'>";
    $imgurl = "../uploads/" . $products['image'];
    echo "<img src='$imgurl' class='image'>";
    echo "<h3 align='center' >" . ($products['prname']) . "</h3>";
    echo "<p align='center'> " . ($products['quantity']) . " unit/s</p>";
    echo "<p align='center'> RM " . number_format($products['prprice'], 2) . " /unit</p>";
    echo "Total: RM " . number_format($totalprice, 2) . "<br>";
    echo "<form action='cart.php' method='get'>";
    echo " <input type='hidden' name='prid' value='$prid'/>";
    echo "<button class='btn btn-success'  style='margin-top:5px; background-color: red;' type='submit' name='deletebtn' onclick='return deleteCart()' value='delete'><i class='fa fa-trash'> Delete</i></button> <br>";
    echo "</form>";
    echo "</div>";
    $sumtotal = $totalprice + $sumtotal;
}
echo "</div>";
echo "</div>";
echo "<div class='container-src'>
<h3>Total Amount: RM " . number_format($sumtotal, 2) . "</h3></div>";
?>

<br>
<br>
<div class="paymentrow">
   <div class="col-75">
      <div class="paymentcontainer">
         <h2>Payment Form</h2>
         <form action="cart.php" method="get">
            <div class="row">
               <div class="col-25">
                  <label for="email">Your Email</label>
               </div>
               <div class="col-75">
                  <input type="text" id="idemail" name="email" value="<?php echo $email ?>" disabled>
               </div>
            </div>
            <div class="row">
               <div class="col-25">
                  <label for="name">Your Name</label>
               </div>
               <div class="col-75">
                  <input type="text" id="idname" name="name" placeholder="Full Name" required>
               </div>
            </div>
            <div class="row">
               <div class="col-25">
                  <label for="phone">Phone Number</label>
               </div>
               <div class="col-75">
                  <input type="text" id="idphone" name="phoneno" placeholder="Phone Number" required>
               </div>
            </div>
            <div class="row">
               <div class="col-25">
                  <label for="homeadress">Home Address</label>
               </div>
               <div class="col-75">
                  <input type="text" id="idhomeaddress" name="homeadress" placeholder="Home Address" required>
               </div>
               <label for="email">The Total Amount(RM)</label>
            </div>
            <div class="col-75">
               <input type="text"  id="idprice" name="price" value="RM <?php echo $sumtotal ?>.00">
            </div>
            <input type="hidden" id="idprice" name="price" value="<?php echo $sumtotal ?>">
            <div class="row">
               <br>
               <input class='paybtn' type="submit" name="paybtn" value="Proceed to Checkout">
            </div>
            </div>
        </form>    
      </div>
   </div>
</div>
</div>
</div>

<div class="w3-container w3-deep-purple w3-center">
   <!--Bottom navigation bar-->
   <p class="w3-large">Created by Tan Ivy. &copy; 2021</p>
</div>
</body>
</html>