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
    if (isset($_POST['submit']))
    {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $gender = $_POST["gender"];
        $phonenumber = $_POST["phonenumber"];
        $dateofbirth = $_POST["dateofbirth"];
        $password = $_POST["password"];
        $confirmpassword = $_POST["confirmpassword"];
        $shapass = sha1($password);
        $otp = rand(1000, 9999);

        if (!(isset($name) || isset($email) || isset($gender) || isset($phonenumber) || isset($dateofbirth) || isset($password) || isset($confirmpassword)))
        {
            echo "<script>alert('Please fill in all required information')</script>";
            echo "<script>window.location.replace('../html/register.html')</script>";
        }
        else
        {
            $sqlregister = "INSERT INTO tbl_user(name,email,gender,phonenumber,dateofbirth,password,otp) VALUES('$name', '$email','$gender','$phonenumber', '$dateofbirth','$shapass','$otp')";
            $checkduplicate = "SELECT * FROM tbl_user WHERE email='$email'";

            try
            {
                $conn->exec($sqlregister);
                echo "<script> alert('Registration successful')</script>";
                echo "<script> window.location.replace('../php/login.php')</script>";
            }
            catch(PDOException $e)
            {
                echo "<script> alert('Registration failed')</script>";
                echo "<script> window.location.replace('../php/register.php')</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
   <head>
      <title>Registration Form</title>
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
         <a href="homepage.php" class="w3-bar-item w3-button"><i class="fa fa-home" ></i>  Home</a>
         <a href="login.php" class="w3-bar-item w3-button w3-right"><i class="fa fa-sign-in" ></i> Login</a>
         <a href="register.php" class="w3-bar-item w3-button w3-right"><i class="fa fa-user" ></i> Register</a>
      </div>
      <div class="main">
         <div class="container">
            <form name="registerForm" action="../php/register.php" onsubmit="return validateRegForm()" method="post">
               <!--Register Validation-->
               <h2>Register</h2>
               <p>Please fill in this form to create an account.</p>
               <center>
                  <img src="https://icon-library.com/images/signup-icon/signup-icon-13.jpg">
                  <!--Register Logo-->
               </center>
               <div class="row">
                  <div class="col-25">
                     <label for="fname">Name</label>
                     <!--Name-->
                  </div>
                  <div class="col-75">
                     <input type="text" id="idname" name="name" placeholder="e.g Tan Ivy" required>
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="email">Email</label>
                     <!--Email-->
                  </div>
                  <div class="col-75">
                     <input type="text" id="idemail" name="email" placeholder="e.g xxx123@gmail.com" required>
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="gender">Gender</label>
                     <!--Gender-->
                  </div>
                  <div class="col-75">
                     <input type="text" id="idgender" name="gender" placeholder="e.g Female/Male" required>
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="phone">Phone Number</label>
                     <!--Phone Number-->
                  </div>
                  <div class="col-75">
                     <input type="text" id="idphone" name="phonenumber" placeholder="e.g 0123456789" required>
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="birthday">Date of Birthday</label>
                     <!--Date of Birthday-->
                  </div>
                  <div class="col-75">
                     <input class="input--style-4" type="date" id="idbirthday" name="dateofbirth" value="" required>
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="password">Password</label>
                     <!--Password-->
                  </div>
                  <div class="col-75">
                     <input type="password" id="idpassword" name="password" placeholder="Password" required>
                  </div>
               </div>
               <div class="row">
                  <div class="col-25">
                     <label for="password">Confirm Password</label>
                     <!--Confirm Password-->
                  </div>
                  <div class="col-75">
                     <input type="password" id="idconfirmpassword" name="confirmpassword"
                        placeholder="Re-enter password" required>
                  </div>
               </div>
               <div class="row">
                  <button type="submit" name="submit" class="registerbtn">Register</button>
                  <!--Register Button-->
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