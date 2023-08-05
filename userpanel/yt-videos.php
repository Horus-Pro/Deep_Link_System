<html lang="en">

<head>
<?php
// Initialize the session
session_start();
 
 // Include config file
require_once "config.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
echo '<script type="text/javascript" src="../js/link.js"></script>';
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login");
    exit;
}
?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="../logo.ico" />
    <title>URLink.app Linking | Userpanel</title>
	<link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
    <link href="assets/css/build.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <!-- sidebar navigation component -->
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <div style="color: black;"><a href="http://urlink.app"><img class ="brand" src="../assets/images/logo.png" width="50" height="50">URLink.app</a></div>
            </div>
            <ul class="list-unstyled components text-secondary">
                <li>
                    <a href="index"><i class="fas fa-home"></i>Dashboard</a>
                </li>
                <li>
                    <a href="#uielementsmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-layer-group"></i>YouTube</a>
                    <ul class="collapse list-unstyled" id="uielementsmenu">
                        <li>
                            <a href="yt-videos"><i class="fas fa-angle-right"></i>Videos</a>
                        </li>
                        <li>
                            <a href="yt-channel"><i class="fas fa-angle-right"></i>Channel</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="facebook"><i class="fas fa-user-friends"></i>Facebook</a>
                </li>
            </ul>
        </nav>
        <div id="body" class="active">
            <!-- navbar navigation component -->
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-light"><i class="fas fa-bars"></i><span></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
<?php

$username = $_SESSION["username"];

$query="SELECT * FROM users WHERE username = ? AND acc_status = 5";
    $status = $link->prepare($query);
    $status->bind_param('s', $username); 
    $status->execute();
    $status->store_result();
    if ($status->num_rows > 0) {
?>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown"><i class="fas fa-link"></i> <span>Admin Panel</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i></a>
                                <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="admincp/users" class="dropdown-item"><i class="fas fa-list"></i> Users</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-database"></i> Back ups</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cloud-download-alt"></i> Updates</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="yoyo" class="dropdown-item"><i class="fas fa-user-shield"></i> Yoyo</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
<?php
    }
?>

                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown"><i class="fas fa-user"></i> <span><?php echo $_SESSION["username"]; ?></span> <i style="font-size: .8em;" class="fas fa-caret-down"></i></a>
                                <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="reset-pw" class="dropdown-item"><i class="fas fa-cog"></i> Reset Password</a></li>
                                        <li><a href="contactus" class="dropdown-item"><i class="fas fa-envelope"></i> Support</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="logout" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- end of navbar navigation -->
            
            <div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3><img class ="brand" src="../assets/images/logo.png" width="50" height="50">YouTube Videos</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">Create Deep Link</div>
                                <div class="card-body">
<?php

$query="SELECT acc_status FROM users WHERE username = :username";
    $status = $link2->prepare($query);
    $status->bindParam(":username", $username, PDO::PARAM_STR); 
    $status->execute();
    $status_result = $status->fetch();
    $acc_status = $status_result["acc_status"];
    if ($acc_status == 0) {
    echo '<center>Your account is <code>NOT Verified</code> Please verify your E-Mail.<br>Sign into your E-mail account and click on the verification link. (check spam or junk box)<br>If you did not receive verification link on your e-mail within 1 hours after registeration please
    <a href="contactus" class="badge badge-info">contact us</a></center>';
    }elseif ($acc_status == 2){
        echo '<center>Your account is <code>blocked</code> please <a href="contactus" class="badge badge-info"> contact us</a> for further assistance.</center>';
    }else{
?>
                                    <p class="card-title">Insert YouTube URL (Example: <code>https://www.youtube.com/watch?v=XXXXXXXXXXX</code> inside this field.</p>

                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                       <div class="input-group">
                                      <input type="text" name="vcode"  class="form-control" placeholder="https://www.youtube.com/watch?v=XXXXXXXXXXX" maxlength="100">
                                      <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                                      <input type="hidden" name="action" value="validate_captcha">
                                      <input  class="btn btn-primary" type="submit" value="Generate">
                                      </div>
                                    </form>
<?php

    //ADD VIDEOS
    if (!empty($_POST['vcode'])) {
    $sql = "INSERT INTO deeplink_prd (YTCode , VideoTitle , clicks , link_status , username)
    VALUES (?, ?, ?, ?, ?)";
    $stmt = $link->prepare($sql); 
    $url = $_POST['vcode'];

    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    $youtube_id = $match[1];

    function get_youtube_title($youtube_id){
    $html = 'https://www.googleapis.com/youtube/v3/videos?id=' . $youtube_id . '&key=AIzaSyDLPaIsDX0AoCoxFiw0gnuVjvQtycd8jJg&part=snippet';
    $response = file_get_contents($html);
    $decoded = json_decode($response, true);
    foreach ($decoded['items'] as $items) {
         $title = $items['snippet']['title'];
         return $title;
    }
}
$title = get_youtube_title($youtube_id);


$videoexist = $youtube_id;
$qry="SELECT * FROM deeplink_prd WHERE YTCode = ? AND username = ?";
    $stmt2 = $link->prepare($qry);
    $stmt2->bind_param('ss', $videoexist, $username); 
    $stmt2->execute();
    $stmt2->store_result();
    if ($stmt2->num_rows > 0) {
    echo("<div class='col-md-8 col-lg-6'><div class='alert alert-light' role='alert'>Video Title : $title</div><div class='alert alert-warning' role='alert'><i class='fas fa-info'></i> Video already exist !!!</div></div>");
    } else {
$linkstatus = 1;
$clicks = 0;

          // reCAPTCHA v3
          if (isset($_POST['g-recaptcha-response'])) {
          $captcha = $_POST['g-recaptcha-response'];
      } else {
          $captcha = false;
      }
      if (!$captcha) {
          //Do something with error
          $reCAPTCHA = "No reCAPTCHA";
      } else {
          $secret   = '6LceTaYaAAAAAHlph7MET4giydWQ1ovZGgzo7SkC';
          $response = file_get_contents(
              "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']
          );
          // use json_decode to extract json response
          $response = json_decode($response);

          if ($response->success === false) {
              //Do something with error
              $reCAPTCHA = "Failed to pass our security";
          }
      //... The Captcha is valid you can continue with the rest of your code
      //... Add code to filter access using $response . score
          elseif ($response->success==true && $response->score <= 0.5) {
              //Do something to denied access
              $reCAPTCHA = "Robot access detected";
          }else{
          
//INSERT to Mysql
$stmt->bind_param("sssss", $youtube_id, $title , $clicks, $linkstatus , $username);
$stmt->execute();

if (empty($title)){
    echo "<div class='col-md-8 col-lg-6'><div class='alert alert-danger' role='alert'><i class='fas fa-exclamation-triangle'></i> Please Enter Valid YouTube URL</div></div>";
    } else {
    echo '<div class="col-md-8 col-lg-6"><div class="alert alert-primary" role="alert">Video Title : '.$title.'</div><div class="alert alert-success"><i class="fas fa-check"></i> Video Link generated successfully.</div></div>' ;
    }
    }
    }
    }
    }
    }
if(!empty($reCAPTCHA)){
echo "<div class='col-md-8 col-lg-6'><div class='alert alert-danger' role='alert'><i class='fas fa-exclamation-triangle'></i> $reCAPTCHA</div></div>";
}
?>
                                </div>
                            </div>
                        </div>


<?php
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };

// Results per page
$results_per_page = 15;
$start_from = ($page-1) * $results_per_page;

$sql2 = "SELECT id, YTCode, VideoTitle, clicks FROM deeplink_prd WHERE username = ? ORDER BY id DESC LIMIT ?, ?";
if($stmt3 = $link->prepare($sql2)){
    $stmt3->bind_param('sss', $username, $start_from, $results_per_page);
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->num_rows();
    if($stmt3->num_rows() > 0){
    $stmt3->bind_result($div, $YTCode, $VideoTitle, $clicks);
        while($stmt3->fetch()){

?>
<center>
<div class="container">
<div class="row">
<div class="col-md-6">
    <div class="card" style="width: 21.85rem; height: 27rem;">
    <div class="card-header"><div id="div<?php echo $div; ?>" class="card-link">https://urlink.app/w?v=<?php echo $YTCode; ?></div></div>
    <center><input type="image" src="https://i.ytimg.com/vi/<?php echo $YTCode; ?>/mqdefault.jpg" width="348" height="190" id="button1" onclick="CopyToClipboard('div<?php echo $div; ?>')"></center>
      <ul class="list-group list-group-flush">
        <li class="list-group-item" style="height: 6rem;"><?php echo $VideoTitle; ?></li>
      </ul>
      <div class="card-body" style="height: 4rem;">
        <a onclick="CopyToClipboard('div<?php echo $div; ?>')" class="btn btn-primary">Copy Link</a>
        <a href="delete?v=<?php echo $YTCode; ?>" class="btn btn-danger">Delete</a>
        <a class="btn btn-success">Hits <span class="badge badge-light"><?php echo $clicks; ?></span></a>
      </div>
    </div>
</div>
</div>
</div>
</center>


<?php
        }
    } else{
//    echo "No records matching your query were found.";
}
}else{
    echo "No records matching your query were found. Please report this issue to website admin";
}

$sql3 = "SELECT * FROM deeplink_prd WHERE username = ? ORDER BY id DESC";
$stmt4 = $link->prepare($sql3);
$stmt4->bind_param('s', $username);
$stmt4->execute();
$stmt4->store_result();
$rows = $stmt4->num_rows();
$total_pages = ceil($rows / $results_per_page); // calculate total pages with results
  // Prev + Next
$prev = $page - 1;
$next = $page + 1;

// Close connection
mysqli_close($link);

if($rows > $results_per_page){

?>

                        </div>
                    </div>
                </div>
<!-- Pagination -->
<nav aria-label="Page navigation example mt-5">
    <ul class="pagination justify-content-center">
        <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
            <a class="page-link"
                href="<?php if($page <= 1){ echo '#'; } else { echo "?page=" . $prev; } ?>">Previous</a>
        </li>

        <?php for($i = max(1, $page - 1); $i <= min($page + 1, $total_pages); $i++ ): ?>
        <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
            <a class="page-link" href="yt-videos?page=<?= $i; ?>"> <?= $i; ?> </a>
        </li>
        <?php endfor; ?>

        <li class="page-item <?php if($page >= $total_pages) { echo 'disabled'; } ?>">
            <a class="page-link"
                href="<?php if($page >= $total_pages){ echo '#'; } else {echo "?page=". $next; } ?>">Next</a>
        </li>
    </ul>
</nav>

<?php
}
?>

            </div>
        </div>
    </div>
    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container"><br><br>
            <div class="row">
                <div class="col-lg-6 col-xs-12">
                    <div class="left-text-content">
                        <p>Copyright &copy; 2021 URLink.app<br>All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://www.google.com/recaptcha/api.js?render=6LceTaYaAAAAAG1Tcp8HGCDAj9sXCS2wPL-SxB8l"></script>
    <script>
        grecaptcha.ready(function() {
        // do request for recaptcha token
        // response is promise with passed token
            grecaptcha.execute('6LceTaYaAAAAAG1Tcp8HGCDAj9sXCS2wPL-SxB8l', {action:'validate_captcha'})
                      .then(function(token) {
                // add token value to form
                document.getElementById('g-recaptcha-response').value = token;
            });
        });
    </script>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="../js/copy_link.js"></script>
</body>
</html>