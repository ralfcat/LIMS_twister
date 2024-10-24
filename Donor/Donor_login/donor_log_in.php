<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "twister";

// Create connection
$link = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection is established
if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}
$error_email = "";
$error_password = "";
$error_activation = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // salted password 
    $password = $password . $email;
    $sql = "SELECT donor_id, email, password, account_activation_hash FROM donor WHERE email = ?";
    //to prevent sql injections
    $stmt = $link->prepare($sql);
    $stmt -> bind_param('s', $email);
    $stmt -> execute();
    $result = $stmt -> get_result(); 

    if ($result->num_rows > 0) {
        // The email exists, now check the account activation status
        $row = $result->fetch_assoc();
        
        // Check if account_activation_hash is empty or null
        if (empty($row['account_activation_hash'])) {
            //The account is activated, check the password
            $hashed_password = $row['password'];
            if (md5($password) == $hashed_password) {
                //Password matches, log the user in and redirect
                $_SESSION['donor_id'] = $row['donor_id'];
                $_SESSION['email'] = $email;
                $_SESSION['donorlogged'] = true;
            
                header("Location: /Donor/Donor_profile/donor_front_page_backend.php");
                exit(); 
            } 
            else {
                $error_password = "The email or password you entered is incorrect.";
            }
        }
        else {
            $error_activation = "You need to activate your account. Please check your email for further instructions.";
        }
    } else {
        $error_email = "The email or password you entered is incorrect.";
    }  

    $stmt->close();
    $link->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="../../BloodAlert_logo.png">
    <title>Donor Login</title>
    <link rel="stylesheet" href="../../stylesheet/reset.css" />
    <link rel="stylesheet" href="../../stylesheet/styles2.css" />
    <script>
        function validateForm() {
            let email = document.forms["loginform"]["email"].value;
            let password = document.forms["loginform"]["password"].value;
            
            let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            
            document.getElementById("error-message").innerHTML = "";
            document.getElementById("error-message2").innerHTML = "";
            if (email == "") {
                document.getElementById("error-message").innerHTML = "Email must be filled out";
                document.getElementById("error-message").classList.add("error-message");
                return false;
            } else if (!emailPattern.test(email)) {
                document.getElementById("error-message").innerHTML = "Please enter a valid email address";
                document.getElementById("error-message").classList.add("error-message");
                return false;
            }
            if (password == "") {
                document.getElementById("error-message2").innerHTML = "Password must be filled out";
                document.getElementById("error-message").classList.add("error-message");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <header>
        <div class="logo-container">
        <a href = "../../index.php">  <img class="logo" src="../../Logo-and-text.png" alt="Logo"> </a>
        </div>
        <nav>
            <ul>
                <li><a href="../../Blood_bank/bbank_log_in.php">Blood Bank Log in</a></li>
            </ul>
        </nav>
    </header>

    <div class=login-container> 
        <div class=login-form>
        <h2>Donor Log in</h2>

            <form name ="loginform" action="donor_log_in.php"  method="POST" onsubmit="return validateForm()">
                <div class="input-group">
                    <input type="text" id="email" name="email" placeholder="Email" />
                </div>
                <div id="error-message" class="error-message">
                    <?php echo $error_email; ?>
                </div>

                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password" />
                </div>
                <div id="error-message2" class="error-message">
                    <?php echo $error_password; ?>
                    <?php echo $error_activation; ?>
                </div>
                
                <button>Log in</button>
            </form>

            <div class="new-user">
                <p>New user? <a href="../../index.php">Create an account here</a></p>
            </div>
        </div>
    </div>
</body>

<footer>
  <p>&copy; 2024 Blood Alert</p>
  <nav>
    <a href="../../about_us.php">About Us</a> |
    <a href="../../integrity_policy.php">Integrity Policy</a> |
    <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
  </nav>
</footer>

</html>

