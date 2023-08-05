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

if(isset($_GET['code']) && !empty($_GET['code']) AND ($_GET['user']) && !empty($_GET['user'])){


$videocode = $_GET['code'];
$username = $_GET['user'];

$sql = "UPDATE deeplink_prd set link_status=0 WHERE YTCode = :videocode AND username = :user";
if($stmt = $link2->prepare($sql)){
$stmt->bindParam(":videocode", $videocode, PDO::PARAM_STR);
$stmt->bindParam(":user", $username, PDO::PARAM_STR);
if($stmt->execute()){
        header("Location: activity?user=$username",true,301);
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