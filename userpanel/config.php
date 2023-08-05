<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DeepLink_db";
// Create connection
$link = new mysqli($servername, $username, $password, $dbname);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$servername2 = "mysql:dbname=$dbname;host=$servername";
// Create connection 2
$link2 = new PDO($servername2, $username, $password);
 
// Check connection 2
if($link2 === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>