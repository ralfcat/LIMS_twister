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
    $sql = "SELECT email, password, account_activation_hash FROM donor WHERE email = ?";
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
                $_SESSION['email'] = $row['email'];
                header("Location: /Donor/Donor_profile/donor_front_page.php");
                exit(); 
            } 
            else {
                $error_password = "Invalid password.";
            }
        }
        else {
            $error_activation = "You need to activate your account. Please check your email for further instructions.";
        }
    } else {
        $error_email = "No user found with that email.";
    }  

    $stmt->close();
    $link->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../BloodAlert_logo.png">
    <title>Donor Log in</title>
    <link rel="stylesheet" href="../../stylesheet/styles.css">
    <link rel="stylesheet" href="../../stylesheet/reset.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&display=swap">
    <script>
        function validateForm() {
            let email = document.forms["loginform"]["email"].value;
            let password = document.forms["loginform"]["password"].value;
            
            let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            
            document.getElementById("error-message").innerHTML = "";
            document.getElementById("error-message2").innerHTML = "";
            if (email == "") {
                document.getElementById("error-message").innerHTML = "Email must be filled out";
                return false;
            } else if (!emailPattern.test(email)) {
                document.getElementById("error-message").innerHTML = "Please enter a valid email address";
                return false;
            }
            if (password == "") {
                document.getElementById("error-message2").innerHTML = "Password must be filled out";
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <header>
        <div class="logo-container">
            <img class="logo" src="../../Logo-and-text.png" alt="Logo">
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
                <div id="error-message" style="color:red;">
                <?php echo $error_email; ?>
                </div>
                <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Password" />
                </div>
                <div id="error-message2" style="color:red;">
                <?php echo $error_password; ?>
                <?php echo $error_activation; ?>
                </div>
                <button class="login_button">Log in</button>
            </form>

            <div class="new-user">
                <p>New user? <a href="/Donor/Donor_reg/create_account.php">Create an account here</a></p>
            </div>
        </div>
    </div>
</body>
</html>


