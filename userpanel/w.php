<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html>
<head>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// GetRedirectUrl Function
function GetRedirectUrl($slug){
include "config2.php";

$sql = "SELECT * FROM deeplink_prd WHERE YTCode= :param";
$result = $conn->prepare($sql);
$result->bindParam(":param", $slug, PDO::PARAM_STR); 
$result->execute();
$resultarray = $result->fetch();
$yturl = $resultarray["YTCode"];
$clicks = $resultarray["clicks"];
$linkstatus = $resultarray["link_status"];

if(($slug == $yturl) && ($linkstatus = 1)){
$sql2 = "UPDATE deeplink_prd set clicks=:clicks+1 where YTCode = :yturl";
if($stmt = $conn->prepare($sql2)){
$stmt->bindParam(":yturl", $yturl, PDO::PARAM_STR);
$stmt->bindParam(":clicks", $clicks, PDO::PARAM_INT);
$stmt->execute();
return $yturl;
}
}else{
  header("Location: http://localhost/",true,301);
  die("Invalid Link!");
  }
}

if(isset($_GET['redirect']) && $_GET['redirect']!="")
{ 
$slug=urldecode($_GET['redirect']);
$yturl= GetRedirectUrl($slug);
unset($conn);

?>

<meta property="og:url" content="https://www.youtube.com/watch?v=<?php echo $yturl; ?>" />
</head>

<?php

//Detect special conditions devices
$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

//do something with this information
if( $iPod || $iPhone || $iPad ){?>
    <script>

    window.onload = function() {
        var userAgent = navigator.userAgent || navigator.vendor || window.opera;
        var vcode = '<?=$yturl?>';
        var url = "https://youtube.com/watch?v="+vcode,
        app = "youtube://"+vcode;
        var desktopFallback = "https://youtube.com/watch?v="+vcode,
        mobileFallback = "https://youtube.com/watch?v="+vcode;

        if( /iPhone|iPad|iPod/i.test(userAgent) ) {
            window.location = app;
            window.setTimeout(function() {
                window.location = url;
                window.location = mobileFallback;
            }, 25);
        } else {
            window.location = url;
            window.location = desktopFallback;
          }
        };

    </script>
<?php 
} elseif($Android){
    $app = "intent://$yturl/#Intent;package=com.google.android.youtube;scheme=vnd.youtube;end";
    header("Location: $app",true,301);
} else {
    header("Location: https://www.youtube.com/watch?v=$yturl",true,301);
    exit;
}
} else{
  header("Location: http://localhost/",true,301);
  }
?>
</html>