<?php
// Include config file
require_once "config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(strlen(trim($_POST["username"])) < 6){
        $username_err = "Username must have atleast 6 characters.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = :username";
        
        if($stmt = $link2->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = :email";
        
        if($stmt = $link2->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $email_err = "This email is already registered.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Validate inputs format
      $username2 = $_POST["username"];
      $password2 = $_POST["password"];
      $email2 = $_POST["email"];
     if (preg_match('/[^A-Za-z0-9]/i',$username2)) {
     $username_err = "Only English letters & numbers allowed (No Space)";
     }elseif (preg_match('/[^A-Za-z0-9_~\-!@#\$%\^&\*\\\]/i',$password2)) {
     $password_err = "Please insert valid format Letters, Numbers and _ ~ - ! @ # $  ^ & *";
     }
     
     if(filter_var($email2, FILTER_VALIDATE_EMAIL)) {
     }else{
     $email_err = "Invalid Email Address";;
     }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($firstname_err) && empty($lastname_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, email, acc_status, subscription, token) VALUES (:username, :password, :email, :acc_status, :subscription, :token)";
         
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
         
        if($stmt = $link2->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":acc_status", $param_accstatus, PDO::PARAM_STR);
            $stmt->bindParam(":subscription", $param_subscription, PDO::PARAM_STR);
            $stmt->bindParam(":token", $token, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_email = $email;
            $param_accstatus = 1;
            $param_subscription = 0;
            $token = bin2hex(random_bytes(50));
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                //header("location: login.php");
                
                // Send activation e-mail
                //require "/home/dmtysnw5ob58/public_html/urlink.app/userpanel/signupemail.php";
                echo '<center><div class="col-md-6 col-lg-6"><div class="alert alert-success"><i class="fas fa-check"></i> Account created successfully, You can login now.</div></div></center>';
                header("Refresh:5; url=login");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
          }
            // Close statement
            unset($stmt);
            }
            }
        }
    // Close connection
    unset($link2);
    }

?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="../logo.ico" />
    <title>Sign up | URLink.app Deep Linking</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/auth.css" rel="stylesheet">
</head>

<body>
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
                    <h6 class="mb-4 text-muted">Create new account</h6>
                    
                    <form id="signup" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group text-left">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Enter Userame" required>
                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-group text-left">
                            <label for="email">Email address</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="Enter Email" required>
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>
                        <div class="form-group text-left">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" placeholder="New Password" required>
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder="Confirm New Password" required>
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div> 
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                            <input type="hidden" name="action" value="validate_captcha">
                        <input id="signup-b" type="submit" class="btn btn-primary shadow-2 mb-4" value="Submit">
                    </form>
                    <p class="mb-0 text-muted">Allready have an account? <a href="https://urlink.app/userpanel/login">Log in</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
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