<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../userpanel");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){




 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
    
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
          
        // Prepare a select statement
        $sql = "SELECT id, username, password, email FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $email);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $email;                            
                            
                            // Redirect user to welcome page
                            header("location: ../userpanel");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
                }
            }
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="../logo.ico" />
    <title>Login | URLink.app Deep Linking</title>
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
                    <h6 class="mb-4 text-muted">Login to your account</h6>
                      <?php 
                      if(!empty($login_err)){
                          echo '<div class="alert alert-danger">' . $login_err . '</div>';
                      }
                      if(!empty($reCAPTCHA)){
                          echo '<div class="alert alert-danger">' . $reCAPTCHA . '</div>';
                      }
                      ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group text-left">
                            <label for="email">Username</label>
                            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Enter Username" required>
                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-group text-left">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required>
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                            <input type="hidden" name="action" value="validate_captcha">
                        <button class="btn btn-primary shadow-2 mb-4">Login</button>
                    </form>
                    <p class="mb-0 text-muted">Don't have account yet? <a href="signup">Signup</a></p>
                </div>
            </div>
        </div>
    </div>
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
</body>

</html>