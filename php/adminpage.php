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
        $sqldelete = "DELETE FROM tbl_products WHERE id = '$prid ' ";
        $stmt = $conn->prepare($sqldelete);

        if ($stmt->execute())
        {
            echo "<script> alert('Delete Successful')</script>";
            echo "<script>window.location.replace('adminpage.php')</script>";
        }
        else
        {
            echo "<script> alert('Delete Failed')</script>";
            echo "<script>window.location.replace('adminpage.php')</script>";

        }
    }

    if (isset($_GET['updatebtn']))
    {

        $proqty = $_GET['qty'];
        $sqlupdateproducts = "UPDATE tbl_products  SET prqty = '$proqty' WHERE id = '$prid' ";
        $stmt = $conn->prepare($sqlupdateproducts);
        if ($stmt->execute())
        {
            echo "<script>alert('Update Qty Successful')</script>";
            echo "<script> window.location.replace('adminpage.php')</script>";
        }
        else
        {
            echo "<script>alert('Update Qty Failed')</script>";
            echo "<script> window.location.replace('adminpage.php')</script>";
        }
    }
}

// Search products
if (isset($_GET["searchbtn"]))
{

    $searchproduct = $_GET['searchproduct'];
    $sqlsearch = "SELECT * FROM tbl_products WHERE prname LIKE '%$searchproduct%' OR  prtype LIKE '%$searchproduct%' ORDER BY id DESC";
    $stmt = $conn->prepare($sqlsearch);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();
}
else
{
    $sqlsearch = "SELECT * FROM tbl_products ORDER BY id DESC";
    $stmt = $conn->prepare($sqlsearch);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();
}

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
   <body onload="loadCookies()">
      <div class="header">
         <img src="../uploads/logo1.png" align="left" hspace="50">
         <!--Logo-->
         <h1>Sweet World Enterprise</h1>
      </div>
      <div class="w3-bar w3-deep-purple w3-large">
         <!--Top navigation bar-->
         <a href="index.php" class="w3-bar-item w3-button"><i class="fa fa-navicon"></i> Product</a>
         <a href="../php/addproduct.php" class="w3-bar-item w3-button "><i class="fa fa-plus" ></i> Add Product</a>
         <a href="homepage.php" class="w3-bar-item w3-button w3-right"><i class="fa fa-sign-out" ></i> Logout</a>
      </div>
      <div class="main">
      <div class="container">
      <h2>Product List</h2>
      <form action="index.php" method="get">
         <div class="search-container">
            <input type="search" id="idsearch" name="searchproduct" class="form-control"
               placeholder="Search Product....">
            <button type="submit" name="searchbtn" value="search" class="btn btn-default">Search</button>
      </form>
      </div>
      
   <?php
echo "<div class='container'>";
echo "<div class='card-row'>";
foreach ($rows as $products)
{
    $prid = $products['id'];
    $quantity = $products['prqty'];
    $image = $products['image'];
    echo "<div class='card'>";

    $imgurl = "../uploads/" . $products['image'];
    echo "<img src='$imgurl' class='image'>";
    echo "<h3 align='center' >" . ($products['prname']) . "</h3>";
    echo "<p align='center' type='hidden'>" . ($products['prtype']) . "</p>";
    echo "<p align='center'> RM" . ($products['prprice']) . "</p>";
    echo "Avail. Qty: " . ($products['prqty']) . " unit/s</p>";
    echo "<form action='adminpage.php' method='get'>";
    echo " <input type='hidden' name='prid' value='$prid'/>";
    echo "<input type='number'  id='qty' name='qty' value='$quantity' min='0' max='500'/>" . "&nbsp";
    echo "<button class='btn btn-success'    type='submit' name='updatebtn' onclick='return updateProducts()' value='update'><i class='fa fa-pencil-square-o'> Update Qty</i></button>" . "<br>";
    echo "<button class='btn btn-success'  style=' background-color: red; ' type='submit' name='deletebtn' onclick='return deleteProducts()' value='delete'><i class='fa fa-trash'> Delete</i></button> <br>";
    echo "</form>";
    echo "</div>";

}
echo "</div>";
echo "</div>";

?>

    </div>
    </div>
    <div class="w3-container w3-deep-purple w3-center">
        <!--Bottom navigation bar-->
        <p class="w3-large">Created by Tan Ivy. &copy; 2021
        </p>
    </div>
</body>

</html>