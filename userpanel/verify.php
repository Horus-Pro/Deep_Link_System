<html lang="en">
<head>
    <link rel="shortcut icon" type="image/x-icon" href="../logo.ico" />
    <title>URLink.app : Account Verification</title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
    <link href="assets/css/build.css" rel="stylesheet">
    <link href="assets/css/auth.css" rel="stylesheet">
</head>
    <div class="wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <!-- ***** Logo Start ***** -->
                          <img class ="brand" src="../assets/images/logo.png" width="100" height="100"><br>
                          URLink.app
                        <!-- ***** Logo End ***** -->
                    </div>
                    <h6 class="mb-4 text-muted">Account Verification</h6>
                    <center>
<?php

// Include config file
require_once "config.php";


if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['t']) && !empty($_GET['t'])){

$email = $_GET['email'];
$token = $_GET['t'];

$sql = "SELECT * FROM users WHERE email= :email AND token = :token AND acc_status = 0";
$stmt = $link2->prepare($sql);
$stmt->bindParam(":email", $email, PDO::PARAM_STR); 
$stmt->bindParam(":token", $token, PDO::PARAM_STR);
$stmt->execute();

if ($stmt->rowCount() > 0) {

$sql2 = "UPDATE users set acc_status = 1 where email= :email AND token = :token";
if($stmt = $link2->prepare($sql2)){
$stmt->bindParam(":email", $email, PDO::PARAM_STR);
$stmt->bindParam(":token", $token, PDO::PARAM_STR);
$stmt->execute();
}
  echo '<div class="alert alert-success"><i class="fas fa-check"></i> Your account has been activated successfully.<br>Forwarding you to Userpanel in 5 seconds...</div>';
  header("Refresh:5; url=index");
}else{
  echo '<div class="alert alert-warning" role="alert">The url is either invalid or You already have activated your account.</div>';
}
}else{
header("Location: login",true,301);
}
 
// Close connection
mysqli_close($link2);

?>
                    </center>
                    <p class="mb-0 text-muted">Not forwarding? <a href="index">Click Here</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>