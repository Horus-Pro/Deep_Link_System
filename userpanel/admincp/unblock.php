<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login");
    exit;
}
 
// Include config file
require_once "../config.php";

if($_SESSION["username"] == "Samurai"){

if(isset($_GET['user']) && !empty($_GET['user'])){

$username = $_GET['user'];

$sql = "UPDATE users set acc_status=1 where username = :user";
if($stmt = $link2->prepare($sql)){
$stmt->bindParam(":user", $username, PDO::PARAM_STR);
if($stmt->execute()){
        header("Location: users",true,301);
        }
}else{
header("Location: ../login",true,301);
}
}else{
header("Location: ../login",true,301);
}
}else{
header("Location: ../login",true,301);
}
 
// Close connection
unset($link2);

?>
</body>
</html>