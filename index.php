<!DOCTYPE html>
<html lang="en">

  <head>
<?php
 // Include config file
require_once "userpanel/config.php";
$base_url='http://127.0.0.1/urlink.app'; // it is your application url
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
 
echo '<script type="text/javascript" src="js/link2.js"></script>';
?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="URLink.app : Mobile App Deep Linking Solution - YouTube, Facebook, Messenger, iOS, Android" />
    <meta name="description" content="Generate Deep Link to iOS or Android app – YouTube, Facebook, Messenger – no SDK required - Mobile App Deep Linking Solution" />
    <meta name="keywords" content="YouTube Channel Videos Facebook Links Mobile App Deep Linking Solution" />
    <meta name="theme-color" content="#ff0000" />
    <meta property="og:site_name" content="URLink.app" />
    <meta property="og:url" content="https://urlink.app" />
    <meta property="og:title" content="URLink.app : Mobile App Deep Linking Solution" />
    <meta property="og:image" content="http://urlink.app/assets/images/URLinkapp.png" />
    <meta property="og:image:width" content="994" />
    <meta property="og:image:height" content="637" />
    <meta property="og:description" content="Sign up and Enjoy instant redirct to YouTube App Videos - Channels - Facebook ..etc" />
    <meta property="og:type" content="website" />
    <link rel="shortcut icon" type="image/x-icon" href="logo.ico" />
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>URLink.app : Mobile App Deep Linking Solution</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

    <link rel="stylesheet" href="assets/css/templatemo-breezed.css">

    <link rel="stylesheet" href="assets/css/owl-carousel.css">

    <link rel="stylesheet" href="assets/css/lightbox.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    </style>
    </head>
    
    <body>
    

    
    
    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="" class="logo">
                        <img src="assets/images/logo.png" width="50" height="50">
                            URLINK.APP
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                            <li class="scroll-to-section"><a href="userpanel/signup">Sign up</a></li>
                            <li class="scroll-to-section"><a href="userpanel/login">Login</a></li>
                            <li class="scroll-to-section"><a href="#contact-us">Contact Us</a></li> 
                            <div class="search-icon">
<!--                                <a href="#search"><i class="fa fa-search"></i></a>
                            </div>-->
                        </ul>        
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- ***** Main Banner Area Start ***** -->
    <div class="main-banner header-text" id="top">
        <div class="Modern-Slider">
          <!-- Item -->
          <div class="item">
            <div class="img-fill">
                <img src="assets/images/slide-01.jpg" alt="">
                <div class="text-content">
                  <h3>Welcome To URLink.app</h3>
                  <h5>Create your short YouTube link</h5>
                  <div class="col-lg-8 offset-lg-2">
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                      <input type="text" name="vcode"  class="form-control" placeholder="Example: https://www.youtube.com/watch?v=XXXXXXXXXXX" maxlength="100" required><br>
                                      <button type="submit" id="form-submit" class="main-button">Generate Link</button>
                                      </div>
                                    </form>
                                    <br>
<?php
    $username = "Anonymous";
    //ADD VIDEOS
    if (!empty($_POST['vcode'])) {
    $sql = "INSERT INTO deeplink_prd (YTCode , VideoTitle , clicks , link_status , username)
    VALUES (?, ?, ?, ?, ?)";
    $stmt = $link->prepare($sql); 
    $url = $_POST['vcode'];
    
if ((strpos($_POST['vcode'], 'youtube.com') == TRUE OR strpos($_POST['vcode'], 'youtu.be') == TRUE)){
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
    echo("<div class='col-lg-8 offset-lg-2'><div class='alert alert-light' role='alert'>Video Title : $title</div><div class='alert alert-warning' role='alert'><i class='fas fa-info'></i> Video already exist !!!</div></div>");
    } else {
$linkstatus = 1;
$clicks = 0;
          
//INSERT to Mysql
$stmt->bind_param("sssss", $youtube_id, $title , $clicks, $linkstatus , $username);
//$stmt->execute();

if (empty($title)){
    echo "<div class='col-lg-8 offset-lg-2'><div class='alert alert-danger' role='alert'><i class='fas fa-exclamation-triangle'></i> Please Enter Valid YouTube URL</div></div>";
    } else {
//    echo '<div class="col-lg-8 offset-lg-2"><div class="alert alert-primary" role="alert">Video Title : '.$title.'</div><div class="alert alert-success"><i class="fas fa-check"></i> Video Link generated successfully.</div></div>' ;
    echo '<div class="col-lg-8 offset-lg-2"><div class="alert alert-success"><i class="fas fa-check"></i> Video Link generated successfully.</div></div>' ;
    ?>
    <div class="col-lg-8 offset-lg-2">
    <div class="card" style="width: 21.85rem; height: 27rem;">
    <div class="card-header">
    <input style="width: 300px;" type="text" value="<?php echo $base_url; echo"/"; echo $youtube_id; ?>" id="myInput">
    </div>
    <center><input type="image" src="https://i.ytimg.com/vi/<?php echo $youtube_id; ?>/mqdefault.jpg" width="348" height="190" id="button1" onclick="CopyToClipboard('deeplink')"></center>
      <ul class="list-group list-group-flush">
        <li class="list-group-item" style="height: 6rem;"><?php echo $title; ?></li>
      </ul>
      <div class="card-body" style="height: 4rem;">
        <a onclick="myFunction()" onmouseout="outFunc()" class="btn btn-primary">Copy Link</a>
      </div>
    </div>
    </div>
    <?php
    }
    }
    }
else {
    echo "<div class='col-lg-8 offset-lg-2'><div class='alert alert-danger' role='alert'><i class='fas fa-exclamation-triangle'></i> Please Enter Valid YouTube URL</div></div>";
    }
    }
?>
                  </div>
                </div>
            </div>
          </div>
          <!-- // Item -->
        </div>
    </div>
    <div class="scroll-down scroll-to-section"><a href="#about"><i class="fa fa-arrow-down"></i></a></div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- ***** About Area Starts ***** -->
    <section class="section" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="left-text-content">
                        <div class="section-heading">
                            <h6>Features</h6>
                            <h2>Why do you choose URLink.app ?</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="service-item">
                                    <img src="assets/images/service-item-01.png" alt="">
                                    <h4>Rocket speed</h4>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="service-item">
                                    <img src="assets/images/service-item-01.png" alt="">
                                    <h4>Robust</h4>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="service-item">
                                    <img src="assets/images/contact-info-03.png" alt="">
                                    <h4>100% uptime</h4>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="service-item">
                                    <img src="assets/images/contact-info-03.png" alt="">
                                    <h4>compatible</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="right-text-content">
                        <p><a rel="nofollow noopener" href="https://urlink.app" target="_parent">URLink.app</a> Mobile App Deep Linking platform for YouTube, Facebook, Messenger on iOS & Android.
                          <br><br>This software sends users directly to an app instead of a website or a store, saving users the time and energy locating a particular page themselves.
                        <br><br>The service is currently in BETA phase and free to use.
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** About Area Ends ***** -->

    <!-- ***** Features Big Item Start ***** -->
    <section class="section" id="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12" data-scroll-reveal="enter left move 30px over 0.6s after 0.4s">
                    <div class="features-item">
                        <div class="features-icon">
                            <img src="assets/images/Youtube.png" width="69" height="28" alt="">
                        </div>
                        <div class="features-content">
                            <h4>YouTube Deep Link</h4>
                            <p>Supporting YouTube Deep Link, Get easy subscribers, More Views by simple click to open YouTube App</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12" data-scroll-reveal="enter bottom move 30px over 0.6s after 0.4s">
                    <div class="features-item">
                        <div class="features-icon">
                            <img src="assets/images/features-icon-1.png" alt="">
                        </div>
                        <div class="features-content">
                            <h4>Mobile App Deep Linking Solution</h4>
                            <p>Unlimited clicks, Cloud-based App Deep Linking, ROCKET SPEED, ROBUST, 100% UPTIME</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12" data-scroll-reveal="enter right move 30px over 0.6s after 0.4s">
                    <div class="features-item">
                        <div class="features-icon">
                            <img src="assets/images/features-icon-1.png" alt="">
                        </div>
                        <div class="features-content">
                            <h4>Smart and COMPATIBLE</h4>
                            <p>Compatible with most platforms, Effective, Link clicks feature.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Features Big Item End ***** -->

    <!-- ***** Features Big Item Start ***** -->
    <section class="section" id="subscribe">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="section-heading">
                        <h6>Deep Linking Solution</h6>
                        <h2>What is Deep Link?</h2>
                    </div>
                    <div class="subscribe-content">
                        <p>Deep links are a type of link that send users directly to an app instead of a website or a store. They are used to send users straight to specific in-app locations, saving users the time and energy locating a particular page themselves, significantly improving the user experience.<br>
                        Very Easy... Sign up then enjoy</p>
                    </div>
                    <div class="section-heading">
                        <a href="userpanel/signup" class="main-filled-button">Sign up Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Features Big Item End ***** -->

    <!-- ***** Contact Us Area Starts ***** -->
    <section class="section" id="contact-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="left-text-content">
                        <div class="section-heading">
                            <h6>Contact Us</h6>
                            <h2>Feel free to keep in touch with us!</h2>
                        </div>
                        <ul class="contact-info">
                            <li><img src="assets/images/contact-info-02.png" alt="">info@urlink.app</li>
                            <li><img src="assets/images/contact-info-03.png" alt="">www.urlink.app</li>
                            <li><a href="contactus"><button type="submit" id="form-submit" class="main-button-icon">Send Message Now <i class="fa fa-arrow-right"></i></button></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Contact Us Area Ends ***** -->

    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xs-12">
                    <div class="left-text-content">
                        <p>Copyright &copy; 2021 URLink.app<br>All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>
    

    <!-- jQuery -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/scrollreveal.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/imgfix.min.js"></script> 
    <script src="assets/js/slick.js"></script> 
    <script src="assets/js/lightbox.js"></script> 
    <script src="assets/js/isotope.js"></script> 
    
    <!-- Global Init -->
    <script src="assets/js/custom.js"></script>

    <script>

        $(function() {
            var selectedClass = "";
            $("p").click(function(){
            selectedClass = $(this).attr("data-rel");
            $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("."+selectedClass).fadeOut();
            setTimeout(function() {
              $("."+selectedClass).fadeIn();
              $("#portfolio").fadeTo(50, 1);
            }, 500);
                
            });
        });

    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-0JVJNDEH01"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-0JVJNDEH01');
    </script>
  </body>
</html>