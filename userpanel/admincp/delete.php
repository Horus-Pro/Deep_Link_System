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

$sql = "DELETE FROM users WHERE username = ? ";
if($stmt = $link->prepare($sql)){
    $stmt->bind_param('s', $username); 
    if($stmt->execute()){
        header("Location: users",true,301);
        }
}else{
    echo "ERROR: Could not able to execute $sql2. " . mysqli_error($conn);
}
}else{
header("Location: ../login",true,301);
}
}else{
header("Location: ../login",true,301);
}
 
// Close connection
mysqli_close($link);

?>
</body>
</html>