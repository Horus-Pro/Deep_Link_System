<html lang="en">
<head>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
    <link href="assets/css/build.css" rel="stylesheet">
</head>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '/home/dmtysnw5ob58/public_html/urlink.app/userpanel/assets/PHPMailer/Exception.php';
require '/home/dmtysnw5ob58/public_html/urlink.app/userpanel/assets/PHPMailer/PHPMailer.php';
require '/home/dmtysnw5ob58/public_html/urlink.app/userpanel/assets/PHPMailer/SMTP.php';

if(isset($email) && !empty($email) AND isset($token) && !empty($token) AND isset($username) && !empty($username)){

   $tokenlink= "https://urlink.app/userpanel/verify?email=$email&t=$token";
   $mail = new PHPMailer();
   $mail->isSMTP();
   $mail->Host = 'localhost';
   $mail->SMTPAuth = TRUE;
   $mail->SMTPAutoTLS = False; 
   $mail->Port = 25; 
   $mail->Username = 'noreply@urlink.app';
   $mail->Password = 'NR4sam@2021';
//   $mail->SMTPSecure = 'tls';
   $mail->SMTPDebug = False;
//   $mail->IsSendMail();
   $mail->From = 'noreply@urlink.app';
   $mail->FromName = 'URLink.app';
   $mail->AddAddress($email);
   $mail->WordWrap = 50;
   $mail->IsHTML(true);
   $mail->Subject = 'Verify Your Email Address - URLink.app';
   $mail->Body = '<p>Hello '.$username.',</p><br> Thank you for registering on URLink.app <br> In order to activate your account, please verify your e-mail address.<br> Click this below link or copy and paste it in your web browser:<br>'.$tokenlink.'<br><br><p>Sincerely,</p> <p>URLink.app</p>';
   if($mail->Send())
   {
   echo '<center><div class="col-md-6 col-lg-6"><div class="alert alert-success"><i class="fas fa-check"></i> Account created successfully, Please verify your E-Mail.<br>Sign into your E-mail and click on the verification link.<br><small class="text-muted">(You may Check Spam or junk box)</small></div></div></center>';
   header("Refresh:10; url=https://urlink.app/userpanel/login");
   }
   else
   {
//    echo $mail->ErrorInfo;
//    header("Location: login.php",true,301);
//    exit;
   }
   }else{
   header("Location: login",true,301);
   }
   
   ?>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>