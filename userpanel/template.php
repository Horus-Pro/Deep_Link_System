<html lang="en">

<head>
<?php
// Initialize the session
session_start();
 
 // Include config file
require_once "config.php";
 
echo '<script type="text/javascript" src="../js/link.js"></script>';
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
                <img src="assets/img/bootstraper-logo.png" alt="bootraper logo" class="app-logo">
            </div>
            <ul class="list-unstyled components text-secondary">
                <li>
                    <a href="dashboard.html"><i class="fas fa-home"></i>Dashboard</a>
                </li>
                <li>
                    <a href="forms.html"><i class="fas fa-file-alt"></i>Forms</a>
                </li>
                <li>
                    <a href="tables.html"><i class="fas fa-table"></i>Tables</a>
                </li>
                <li>
                    <a href="charts.html"><i class="fas fa-chart-bar"></i>Charts</a>
                </li>
                <li>
                    <a href="icons.html"><i class="fas fa-icons"></i>Icons</a>
                </li>
                <li>
                    <a href="#uielementsmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-layer-group"></i>UI Elements</a>
                    <ul class="collapse list-unstyled" id="uielementsmenu">
                        <li>
                            <a href="ui-buttons.html"><i class="fas fa-angle-right"></i>Buttons</a>
                        </li>
                        <li>
                            <a href="ui-badges.html"><i class="fas fa-angle-right"></i>Badges</a>
                        </li>
                        <li>
                            <a href="ui-cards.html"><i class="fas fa-angle-right"></i>Cards</a>
                        </li>
                        <li>
                            <a href="ui-alerts.html"><i class="fas fa-angle-right"></i>Alerts</a>
                        </li>
                        <li>
                            <a href="ui-tabs.html"><i class="fas fa-angle-right"></i>Tabs</a>
                        </li>
                        <li>
                            <a href="ui-date-time-picker.html"><i class="fas fa-angle-right"></i>Date & Time Picker</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#authmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-user-shield"></i>Authentication</a>
                    <ul class="collapse list-unstyled" id="authmenu">
                        <li>
                            <a href="login.html"><i class="fas fa-lock"></i>Login</a>
                        </li>
                        <li>
                            <a href="signup.html"><i class="fas fa-user-plus"></i>Signup</a>
                        </li>
                        <li>
                            <a href="forgot-password.html"><i class="fas fa-user-lock"></i>Forgot password</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#pagesmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-copy"></i>Pages</a>
                    <ul class="collapse list-unstyled" id="pagesmenu">
                        <li>
                            <a href="blank.html"><i class="fas fa-file"></i>Blank page</a>
                        </li>
                        <li>
                            <a href="404.html"><i class="fas fa-info-circle"></i>404 Error page</a>
                        </li>
                        <li>
                            <a href="500.html"><i class="fas fa-info-circle"></i>500 Error page</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="users.html"><i class="fas fa-user-friends"></i>Users</a>
                </li>
                <li>
                    <a href="settings.html"><i class="fas fa-cog"></i>Settings</a>
                </li>
            </ul>
        </nav>
        <!-- end of sidebar component -->
        <div id="body" class="active">
            <!-- navbar navigation component -->
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-light"><i class="fas fa-bars"></i><span></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown"><i class="fas fa-link"></i> <span>Quick Links</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i></a>
                                <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-list"></i> Access Logs</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-database"></i> Back ups</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cloud-download-alt"></i> Updates</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-user-shield"></i> Roles</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown"><i class="fas fa-user"></i> <span><?php echo $_SESSION["username"]; ?></span> <i style="font-size: .8em;" class="fas fa-caret-down"></i></a>
                                <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-address-card"></i> Profile</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-envelope"></i> Messages</a></li>
                                        <li><a href="reset-pw.php" class="dropdown-item"><i class="fas fa-cog"></i> Reset Password</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
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
                        <h3>URLink.app</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">Create Deep Link</div>
                                <div class="card-body">
<?php

$username = $_SESSION["username"];
echo $username;
$query="SELECT * FROM users WHERE username = ? AND acc_status = 0";
    $status = $link->prepare($query);
    $status->bind_param('s', $username); 
    $status->execute();
    $status->store_result();
    if ($status->num_rows > 0) {
    echo '<center>Your account is <code>NOT Verified</code> Please verify your E-Mail.<br>Sign into your E-mail account and click on the verification link. (check spam or junk box)<br>If you did not receive verification link on your e-mail within 1 hours after registeration please
    <a href="contactus" class="badge badge-info">contact us</a></center>';
    } else {
?>
                                    <p class="card-title">Insert YouTube URL (Example: <code>https://www.youtube.com/watch?v=XXXXXXXXXXX</code> inside this field.</p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
   <div class="input-group">
  <input type="text" name="vcode"  class="form-control" placeholder="https://www.youtube.com/watch?v=XXXXXXXXXXX" maxlength="100">
  <input  class="btn btn-primary" type="submit" value="Generate">
  </div>
</form>
<?php

    //ADD VIDEOS
    if (empty($_POST['vcode'])) {
        echo "<p class='card-text'><small class='text-muted'>Please enter YouTube URL !!!</small></p>";
    } else {
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
    echo("<div class='col-md-6 col-lg-6'><div class='alert alert-light' role='alert'>Video Title : $title</div><div class='alert alert-warning' role='alert'><i class='fas fa-info'></i> Video already exist !!!</div></div>");
    } else {
$linkstatus = 1;
$clicks = 0;
//INSERT to Mysql
$stmt->bind_param("sssss", $youtube_id, $title , $clicks, $linkstatus , $username);
$stmt->execute();

if (empty($title)){
    echo "<div class='col-md-6 col-lg-6'><div class='alert alert-danger' role='alert'><i class='fas fa-exclamation-triangle'></i>  Please Enter Valid YouTube URL</div></div>";
    } else {
    echo '<div class="col-md-6 col-lg-6"><div class="alert alert-light" role="alert">Video Title : '.$title.'</div><div class="alert alert-primary" role="alert">New URL : https://urlink.app/w?v='.$youtube_id.'</div><div class="alert alert-secondary" role="alert">Youtube link: '.$url.'</div><div class="alert alert-success"><i class="fas fa-check"></i> Video Link generated successfully.</div></div>' ;
    }
    }
    }
    }
?>
                                </div>
                            </div>
                        </div>


<?php

$sql2 = "SELECT * FROM deeplink_prd WHERE username = ? ORDER BY id DESC";
if($stmt3 = $link->prepare($sql2)){
    $stmt3->bind_param('s', $username); 
    $stmt3->execute();
    $result = $stmt3->get_result();
        while($row = $result->fetch_assoc()){
            echo "<tr>";
            $YTCode = $row['YTCode'];
            $VideoTitle = $row['VideoTitle'];
            $div = $row['id'];
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
        <a class="btn btn-success">Clicks <span class="badge badge-light"><?php echo $row['clicks']; ?></span></a>
      </div>
    </div>
</div>
</div>
</center>


<?php
        }
    } else{
    echo "No records matching your query were found. Please report this issue to website admin";
}
 
// Close connection
mysqli_close($link);

?>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="../js/copy_link.js"></script>
</body>
</html>