<?php
require_once 'bbank_front_page_backend.php';

use function FrontEnd\write_js;
use function FrontEnd\write_console;

error_reporting(E_ERROR | E_PARSE);

$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'twister';

$link = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection is established
if (!$link) {
    die('Connection failed: ' . mysqli_connect_error());
}

$error_email = "";
$error_password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $salted = $password . $email;
    $password_hash = hash("md5", $salted);

    // Use prepared statements to prevent SQL injection
    $email_req = "SELECT email, password FROM Blood_Bank WHERE email = ?";
    $stmt = $link->prepare($email_req);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $error_email = "No user found with that email.";
        write_js("console.log('No user found with that email.');");
    } else {
        $row = $result->fetch_assoc();
        $password_db = $row['password'];

        if ($password_db != $password_hash) {
            $error_password = "You entered the wrong password.";
            write_js("console.log('You entered the wrong password.');");
        } else {
            session_start();
            $_SESSION['email'] = $row['email'];
            $_SESSION['loggedin'] = true;
            header("Location: bbank_front_page.php");
            exit;
        }
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
    <title>Blood Bank Login</title>
    <link rel="stylesheet" href="../../stylesheet/reset.css">
    <link rel="stylesheet" href="../../stylesheet/styles2.css">
    
    <script>
        function validateForm() {
            document.getElementById('error-email').innerHTML = "";
            document.getElementById('error-password').innerHTML = "";

            let email = document.forms["login-form"]["email"].value;
            let password = document.forms["login-form"]["password"].value;

            let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (email == "") {
                document.getElementById('error-email').innerHTML = "Email must be filled out";
                return false;
            } else if (!emailPattern.test(email)) {
                document.getElementById('error-email').innerHTML = "Please enter a valid email address";
                return false;
            }
            if (password == "") {
                document.getElementById('error-password').innerHTML = "Password must be filled out";
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

    <div class="login-container">
        <div class="login-form">
            <h2>Blood Bank Log in</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validateForm();" method="POST" id="login-form">
                <div class="input-group">
                    <input type="text" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" />
                </div>
                <div id="error-email" class="error-message">
                    <?php echo $error_email; ?>
                </div>
                
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password" />
                </div>
                <div id="error-password" class="error-message">
                    <?php echo $error_password; ?>
                </div>

                <button>Log in</button>
            </form>

            <div class="new-user">
                <p>Want to register? <a href="mailto:bloodalert.twister@gmail.com?subject=Request of blood bank account">Contact us</a></p>
            </div>
        </div>
    </div>
</body>

<footer>
    <p>&copy; 2024 Blood Alert</p>
    <nav>
        <a href="../about_us.html">About Us</a> |
        <a href="../integrity_policy.html">Integrity Policy</a> |
        <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
    </nav>
</footer>

</html>
