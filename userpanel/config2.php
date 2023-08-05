<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$host = "localhost";
$username = "root";
$password = "";
$dbname = "DeepLink_db";
// Create connection

$servername = "mysql:dbname=$dbname;host=$host";
// Create connection 2
$conn = new PDO($servername, $username, $password);
 
// Check connection 2
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>