<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login");
    exit;
}
 
// Include config file
require_once "config.php";

if(isset($_GET['v']) && !empty($_GET['v'])){

$videocode = $_GET['v'];
$username = $_SESSION["username"];
$sql2 = "DELETE FROM deeplink_prd WHERE YTCode = ? AND username = ? ";
if($stmt2 = $link->prepare($sql2)){
    $stmt2->bind_param('ss', $videocode, $username); 
    if($stmt2->execute()){
        header("Location: yt-videos",true,301);
        }
} else{
    echo "ERROR: Could not able to execute $sql2. " . mysqli_error($link);
}
}else{
header("Location: login",true,301);
}
// Close connection
mysqli_close($link);

?>
</body>
</html>