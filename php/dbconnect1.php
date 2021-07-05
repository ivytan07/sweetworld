<?php
$servername= "localhost";
$username = "mywonder_sweetworldadmin";
$password = "Tanivy5106";
$dbname = "mywonder_sweetworld";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>