<?php
session_start();
include_once ("dbconnect1.php");
if (!isset($_COOKIE['email']))
{
    echo "<script>loadCookies()</script>";
}
else
{
    $email = $_COOKIE['email'];
    if (isset($_POST['submit']))
    {
        $email = $_POST['email'];
        $adminemail = 'admin1@gmail.com';
        $password = sha1($_POST['password']);
        $_SESSION["email"] = $email;

        $sqllogin = "SELECT * FROM tbl_user WHERE email = '$email' AND password = '$password' AND EMAIL!= 'admin1@gmail.com'";
        $result = $conn->query($sqllogin);

        $sqladminlogin = "SELECT * FROM tbl_user WHERE email = '$adminemail' AND password = '$password'";
        $adminresult = $conn->query($sqladminlogin);

        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {

                echo "<script> alert('Login successful')</script>";
                echo "<script> window.location.replace('../php/index.php')</script>";
            }
        }
        else if ($adminresult->num_rows > 0)
        {
            while ($row = $adminresult->fetch_assoc())
            {

                echo "<script> alert('Admin Login successful')</script>";
                echo "<script> window.location.replace('../php/adminpage.php')</script>";
            }
        }
        else
        {

            echo "<script> alert('Login failed')</script>";
            echo "<script> window.location.replace('../php/login.php')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
   <head>
      <title>Login Form</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <script src="../js/validate.js"></script>
      <link rel="stylesheet" href="../css/style.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   </head>
   <body>
      <div class="header">
         <img src="../uploads/logo1.png" align="left" hspace="40">
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
            <form name="loginForm" action="../php/login.php" onsubmit="return validateLoginForm()" method="post">
               <!--Login validation-->
               <h2>Login</h2>
               <center>
                  <img
                     src="https://www.seekpng.com/png/full/138-1387775_login-to-do-whatever-you-want-login-icon.png">
                  <!--Login Icon-->
               </center>
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
                     <label for="password">Password</label>
                     <!--Password-->
                  </div>
                  <div class="col-75">
                     <input type="password" id="idpassword" name="password" placeholder="Password" required>
                  </div>
               </div>
               <div class="form-group">
                  <button type="submit" name="submit" class="loginbtn">Login</button>
                  <!--Login Button-->
               </div>
               <br>
               Don't have an account? <a href="register.php" class="register">Register Now</a>
               <!--Link to Register Page-->
            </form>
         </div>
      </div>
      <div class="w3-container w3-deep-purple w3-center">
         <!--Bottom navigation bar-->
         <p class="w3-large">Created by Tan Ivy. &copy; 2021</p>
      </div>
   </body>
</html>