<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>URLink.app Linking : Mobile App Deep Linking Solution</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

    <link rel="stylesheet" href="assets/css/templatemo-breezed.css">

    <link rel="stylesheet" href="assets/css/owl-carousel.css">

    <link rel="stylesheet" href="assets/css/lightbox.css">
    </style>
    </head>
    
    <body>
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
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-xs-12">
                    <div class="contact-form">
                        <form id="contact" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                          <div class="row">

<?php
// Define variables and initialize with empty values
$name = $email = $phone = $subjecttext = $message = "";
$name_err = $email_err = $subjecttext_err = $message_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

/*     if(empty(trim($_POST["name"]))){
      $name_err = "Please enter your name";     
     }
     if(empty(trim($_POST["subject"]))){
      $subjecttext_err = "Please enter subject";     
     }
     if(empty(trim($_POST["message"]))){
      $message_err = "Please enter your message";     
     }*/
     $email= $_POST["email"];
     if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
     }else{
     $email_err = "<div class='alert alert-danger' role='alert'>Invalid Email Address format</div>";
     }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($email_err) && empty($subjecttext_err) && empty($message_err)){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subjecttext = $_POST['subject'];
    $message = $_POST['message'];
    $formcontent =" From: $name \n Phone: $phone \n Message: $message";
    $recipient = "info@urlink.app";
    $subject = $subjecttext;
    $mailheader = "From: $email \r\n";
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
    if (mail($recipient, $subject, $formcontent, $mailheader) or die("Error!")){
    echo"<br>";
    echo "<div class='alert alert-info' role='alert'>Thank you for your message and we will get back to you as soon as possible.</div>";
    header("Refresh:10; url=https://urlink.app");
    }else{
    echo "failed";
    }
    }
    }
    }
    }
    if(!empty($reCAPTCHA)){
    echo '<div class="alert alert-danger" role="alert">' . $reCAPTCHA . '</div>';
    }
?>

                            <div class="col-md-6 col-sm-12">
                              <fieldset>
                                <input name="name" type="text" id="name" placeholder="Your Name *" maxlength="50" required>
                              </fieldset>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <fieldset>
                                <input name="phone" type="text" id="phone" placeholder="Your Phone" maxlength="20">
                              </fieldset>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <fieldset>
                                <input name="email" type="email" id="email" placeholder="Your Email *" maxlength="100" required>
                                <?php echo $email_err; ?>
                              </fieldset>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <fieldset>
                                <input name="subject" type="text" id="subject" placeholder="Subject*" maxlength="100" required>
                              </fieldset>
                            </div>
                            <div class="col-lg-12">
                              <fieldset>
                                <textarea name="message" rows="6" id="message" placeholder="Message*" maxlength="1000" required></textarea>
                              </fieldset>
                            </div>
                                <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                                <input type="hidden" name="action" value="validate_captcha">
                            <div class="col-lg-12">
                              <fieldset>
                                <button type="submit" id="form-submit" class="main-button-icon">Send Message Now <i class="fa fa-arrow-right"></i></button>
                              </fieldset>
                            </div>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Contact Us Area Ends ***** -->
    
   
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
    
  </body>
</html>