<?php
include ('dbconnect.php');

if (isset($_POST['submit']))
{
    $prname = $_POST['name'];
    $prtype = $_POST['type'];
    $prprice = $_POST['price'];
    $prqty = $_POST['quantity'];
    $image = uniqid() . '.jpg';

    if (file_exists($_FILES["uploadImage"]["tmp_name"]) || is_uploaded_file($_FILES["uploadImage"]["tmp_name"]))
    {
        $sqlproduct = "INSERT INTO tbl_products (prname, prtype, prprice, prqty, image) VALUES ('$prname', '$prtype', '$prprice', '$prqty', '$image')";
        if ($conn->exec($sqlproduct))
        {
            uploadImage($image);
            echo "<script> alert('Add New Product Successful')</script>";
            echo "<script> window.location.replace('../php/adminpage.php')</script>";
        }
        else
        {
            echo "<script>alert('Failed')</script>";
            return;
        }
    }
    else
    {
        echo "<script>alert('Image not available')</script>";
        return;
    }
}

function uploadImage($image)
{
    $target_dir = "../uploads/";
    $target_file = $target_dir . $image;
    move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $target_file);
}

?>


<!DOCTYPE html>
<html>
   <head>
      <title>Sweet World Enterprise</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <script src="../js/validate.js"></script>
      <link rel="stylesheet" href="../css/style.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
         <a href="../php/addproduct.php" class="w3-bar-item w3-button"><i class="fa fa-plus" ></i> Add Product</a>
         <a href="homepage.php" class="w3-bar-item w3-button w3-right"><i class="fa fa-sign-out" ></i> Logout</a>
      </div>
      <body>
         <div class="main">
            <div class="container">
               <form name="newProductForm" action="" method="POST" enctype="multipart/form-data">
                  <h2>Add New Product</h2>
                  <p>Please fill in this form to add new product.</p>
                  <div class="row">
                     <div class="col-25">
                        <label for="primage">Product Image</label>
                        <!--Product Image-->
                     </div>
                     <div class="col-75" align="center">
                        <img class="imgselection" src="images.png"><br>
                        <input type="file" onchange="previewFile()" id="uploadImage" name="uploadImage" accept="image/*"><br>
                        <!--Image validation-->
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-25">
                        <label for="prname">Product Name</label>
                        <!--Product Name-->
                     </div>
                     <div class="col-75">
                        <input type="text" id="prname" name="name" placeholder="e.g Brownie Cake">
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-25">
                        <label for="prtype">Product Type</label>
                        <!--Product Type-->
                     </div>
                     <div class="col-75">
                        <select type="text" id="prtype" name="type">
                           <option value="noselection">--- Please select the type of products ---</option>
                           <option value="Cake">Cake</option>
                           <option value="Flour">Flour</option>
                           <option value="Nuts">Nuts</option>
                           <option value="Butter">Butter</option>
                           <option value="Milk">Milk</option>
                        </select>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-25">
                        <label for="prprice">Product Price (RM)</label>
                        <!--Product Price-->
                     </div>
                     <div class="col-75">
                        <input type="text" id="prprice" name="price" placeholder="e.g 10.00">
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-25">
                        <label for="prqty">Product Quantity</label>
                        <!--Product Quantity-->
                     </div>
                     <div class="col-75">
                        <input type="text" id="prqty" name="quantity" placeholder="e.g 1">
                     </div>
                  </div>
                  <br>
                  <div class="row">
                     <button type="submit" name="submit" class="addbtn">Add</button><br>
                     <!--Add Button-->
                  </div>
               </form>
            </div>
         </div>
         <div class="w3-container w3-deep-purple w3-center">
            <!--Bottom navigation bar-->
            <p class="w3-large">Created by Tan Ivy. &copy; 2021</p>
         </div>
   </body>
</html>