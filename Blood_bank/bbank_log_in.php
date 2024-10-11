<?php

require_once 'bbank_front_page_backend.php';

use function FrontEnd\write_js as write_js;
use function FrontEnd\write_console as write_console;

error_reporting(E_ERROR | E_PARSE);

$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'twister';






$link = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection is established
if (mysqli_connect_error()) {
    die('Connection failed: ' . mysqli_connect_error());
}




?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../BloodAlert_logo.png">
    <title>Blood Bank Login</title>
    <link rel="stylesheet" href="../../stylesheet/reset.css">
    <link rel="stylesheet" href="../../stylesheet/styles2.css">
    <script>
            <?php
    $messages = [
        'login-required' => 'You need to be logged in to see the requested page',
        'logged-out' => 'Successfully logged out',
        'wrong-password' => 'You have entered the wrong password'
    ];
    // delete this
    if (isset($messages[$_GET['msg']])) {
        echo "console.log( 'you are trying to access a page that cannot be accesse');";

        // $x = $messages[$_GET['msg']];
        echo "document.addEventListener('DOMContentLoaded', function() {";
        // echo "console.log( 'there is a login error $x');";
        echo "let x = document.getElementById('log-errs');";
        echo 'x.innerHTML = "' . htmlspecialchars($messages[$_GET['msg']]) . '";';
        echo "});";
     
    }
    ?>
        function validateForm() {
            document.getElementById('log-errs').innerHTML = "";
            let email = document.forms["login-form"]["email"].value;
            let password = document.forms["login-form"]["password"].value;

            let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            document.getElementById("error-message").innerHTML = "";

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
                document.getElementById("error-message").innerHTML = "Password must be filled out";
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
                <li><a href="../Donor/Donor_login/donor_log_in.php">Donor Log in</a></li>
            </ul>
        </nav>
    </header>
    <div class=login-container>
        
        <div class=login-form>
        <p id="log-errs"></p>
            <h2>Blood Bank Log in</h2>
            <form action=<?php echo $_SERVER['PHP_SELF']; ?> onsubmit="return validateForm();" method="POST" id="login-form">
                <div class="input-group">
                    <input type="text" id="email" name="email" placeholder="Email" />
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password" />
                </div>
                <button class="login_button">Log in</button>
            </form>
            <div class="new-user">
                <p>Want to register? <a href="mailto:bloodalert.twister@gmail.com?subject=Request of blood bank account">Contact us</a></p> <br>
                <p id="error-message"></p>
            </div>
        </div>
    </div>
</body>

<footer>
  <p>&copy; 2024 Blood Alert</p>
  <nav>
    <a href="#about_us.html">About Us</a> |
    <a href="integrity_policy.html">Integrity Policy</a> |
    <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
  </nav>
</footer>
</html>

<?php

// if ($_SERVER["REQUEST_METHOD"] == "GET") {
//     write_js("console.log('a get request occured');");


// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    write_js("console.log('in the post request fxn right now');");

    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_hash = hash("md5", $password);

    $email_req = "SELECT COUNT(email), email FROM Blood_Bank WHERE email = '" . $email . "'";
    $res = $link->query($email_req);
    $row = $res->fetch_assoc();
    $count = $row['COUNT(email)'];

    if ($count == 0) {
        write_js("console.log('i enetered a non existing email');");

        $str = "document.getElementById('error-message').innerHTML = 'The email you entered does not exist.';";
        write_js($str);
    } else {
        $email_db = $row['email'];

        write_js("console.log('i enetered a existing email that is present in the databse where the email is " . $email_db . "');");
        $email_req = "SELECT password FROM Blood_Bank WHERE email = '" . $email_db . "'";
        $res = $link->query($email_req);
        $row = $res->fetch_assoc();
        $password_db = $row['password'];

        if ($password_db != $password_hash) {
            write_js("console.log('i entered the wrong password');");
            $err = "document.getElementById('error-message').innerHTML = 'You entered the wrong password.';";
            write_js($err);
        } else {
            $_SESSION['email'] = $email_db;
            $_SESSION['loggedin'] = true;
            header("Location: bbank_front_page.php");
            exit;
        }
    }
}




?>