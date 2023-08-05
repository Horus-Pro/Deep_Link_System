<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login");
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
$username = $_SESSION["username"];
$email = $_SESSION["email"];

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
    
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
    
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                require_once "/home/dmtysnw5ob58/public_html/urlink.app/userpanel/pwemail.php";
                session_destroy();
                header("Refresh:5; url=login");
                exit();
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
    <title>Reset Password | URLink.app Deep Linking</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/auth.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <img class ="brand" src="../assets/images/logo.png" width="100" height="100"><br>
                        URLink.app
                    </div>
                    <h6 class="mb-4 text-muted">Reset Password</h6>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group text-left">
                            <label for="new_password">New Password</label>
                            <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>" required>
                            <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                        </div>
                        <div class="form-group text-left">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" required>
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                            <input type="hidden" name="action" value="validate_captcha">
                        <button class="btn btn-primary shadow-2 mb-4">Submit</button><a class="btn btn-secondary shadow-2 mb-4 " href="index">Cancel</a>
                    </form>
                    <p class="mb-0 text-muted">Don't have account yet? <a href="signup">Signup</a></p>
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