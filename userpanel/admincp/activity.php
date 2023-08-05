<!doctype html>
<!-- 
* Bootstrap Simple Admin Template
* Version: 2.1
* Author: Alexis Luna
* Website: https://github.com/alexis-luna/bootstrap-simple-admin-template
-->
<html lang="en">

<head>
<?php
// Initialize the session
session_start();
 
 // Include config file
require_once "../config.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login");
    exit;
}
?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="../../logo.ico" />
    <title>URLink.app Linking | Users - Admin Panel</title>
    <link href="../assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="../assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="../assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link href="../assets/css/master.css" rel="stylesheet">
    <link href="../assets/css/build.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <!-- sidebar navigation component -->
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <div style="color: black;"><a href="http://urlink.app"><img class ="brand" src="../../assets/images/logo.png" width="50" height="50">URLink.app</a></div>
            </div>
            <ul class="list-unstyled components text-secondary">
                <li>
                    <a href="../../userpanel"><i class="fas fa-home"></i>Dashboard</a>
                </li>
                <li>
                    <a href="#uielementsmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-layer-group"></i>YouTube</a>
                    <ul class="collapse list-unstyled" id="uielementsmenu">
                        <li>
                            <a href="../yt-videos"><i class="fas fa-angle-right"></i>Videos</a>
                        </li>
                        <li>
                            <a href="../yt-channel"><i class="fas fa-angle-right"></i>Channel</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="../facebook"><i class="fas fa-user-friends"></i>Facebook</a>
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

if(isset($_GET['user']) && !empty($_GET['user'])){

$target_user = $_GET['user'];

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
                                        <li><a href="users" class="dropdown-item"><i class="fas fa-list"></i> Users</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-database"></i> Back ups</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cloud-download-alt"></i> Updates</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="../yoyo" class="dropdown-item"><i class="fas fa-user-shield"></i> Yoyo</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown"><i class="fas fa-user"></i> <span><?php echo $_SESSION["username"]; ?></span> <i style="font-size: .8em;" class="fas fa-caret-down"></i></a>
                                <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="../reset-pw" class="dropdown-item"><i class="fas fa-cog"></i> Reset Password</a></li>
                                        <li><a href="../contactus" class="dropdown-item"><i class="fas fa-envelope"></i> Support</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="../logout" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
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
                        <h3><img class ="brand" src="../../assets/images/logo.png" width="50" height="50"><?php echo $target_user; ?></h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                <a class="btn btn-info">Total Links
                                <?php
                                  $query2="SELECT * FROM deeplink_prd WHERE username = ?";
                                  $rows = $link->prepare($query2); 
                                  $rows->bind_param('s', $target_user);
                                  $rows->execute();
                                  $rows->store_result();
                                  $row_num = $rows->num_rows();
                                  echo  "<span class='badge badge-light'>$row_num</span>";
                                ?></a>
                                </div>
                                <div class="card-body">
                                    <p class="card-title"></p>
                                    <table class="table table-hover" id="dataTables-example" width="100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>YTCode</th>
                                                <th>VideoTitle</th>
                                                <th>Clicks</th>
                                                <th>Status</th>
                                                <th>Reg_Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php

$sql = "SELECT * FROM deeplink_prd WHERE username = :target_user";
$stmt = $link2->prepare($sql);
$stmt->bindParam(":target_user", $target_user, PDO::PARAM_STR);
$stmt->execute();
while($row = $stmt->fetch()){

             //Set Account Status
            if($row['link_status'] == 0){
                $link_status = "Stopped";
                $status_action = "unblocklink?code=";
                $blockword = "Unblock";
                }elseif($row['link_status'] == 1){
                $link_status = "Active";
                $status_action = "blocklink?code=";
                $blockword = "Block";
                }else{
                $link_status = "Undefined";
                $status_action = "blocklink?code=";
                $blockword = "Block";
                }

                                            echo "<tr>";
                                                echo "<td>" . $row['id'] . "</td>";
                                                echo "<td>" . $row['YTCode'] . "</td>";
                                                echo "<td>" . $row['VideoTitle'] . "</td>";
                                                echo "<td>" . $row['clicks'] . "</td>";
                                                echo "<td>" . $link_status . "</td>";;
                                                echo "<td>" . $row['Reg_Date'] . "</td>";
                                                echo '<td><a href="'.$status_action.''.$row['YTCode'].'&user='.$target_user.'" class="btn btn-warning">'.$blockword.'</a> <a href="deletelink?code='.$row['YTCode'].'&user='.$target_user.'" class="btn btn-danger">Delete</a></td>';
                                            echo "</tr>";
}
?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php
unset($link2);
mysqli_close($link);
}else {
    header("Location: ../yt-videos",true,301);
    exit;
}
}else {
    header("Location: ../yt-videos",true,301);
    exit;
}
?>
            </div>
        </div>
    </div>
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/datatables/datatables.min.js"></script>
    <script src="../assets/js/initiate-datatables.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>