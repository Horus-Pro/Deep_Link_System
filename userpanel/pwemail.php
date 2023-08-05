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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '/home/dmtysnw5ob58/public_html/urlink.app/userpanel/assets/PHPMailer/Exception.php';
require '/home/dmtysnw5ob58/public_html/urlink.app/userpanel/assets/PHPMailer/PHPMailer.php';
require '/home/dmtysnw5ob58/public_html/urlink.app/userpanel/assets/PHPMailer/SMTP.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($email) && !empty($email) AND isset($username) && !empty($username)){

   $contactus = "https://urlink.app/contactus";
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
   $mail->Subject = 'Your Password changed - URLink.app';
   $mail->Body = '<p>Hello '.$username.',</p><br> Your password has been changed successfully.<br><br>If you did not perform this action, please <a href = "'.$contactus.'">contact us</a> immediately<br><br><p>Sincerely,</p> <p>URLink.app</p>';
   if($mail->Send())
   {
   echo '<center><div class="col-md-6 col-lg-6"><div class="alert alert-success"><i class="fas fa-check"></i> Your password has been changed successfully</div></div></center>';
   }
   else{
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