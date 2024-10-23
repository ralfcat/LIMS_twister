<?php
session_start();

use function FrontEnd\write_js;
use function FrontEnd\write_console;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "twister";

// Create connection
$link = new mysqli($servername, $username, $password, $dbname);

// Check if connection is established
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

$blood_bank_email = $_SESSION['email'];
$error_email = "";
$success_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donor_email = $_POST['email'];
    $donation_date = $_POST['donation-date'];


    $sql = "SELECT donor_id FROM Donor WHERE email = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('s', $donor_email);
    $stmt->execute();
    $stmt->bind_result($donor_id);
    $stmt->fetch();
    $stmt->close();
    
    $sql2 = "SELECT blood_bank_id FROM blood_bank WHERE email = ?";
    $stmt2 = $link->prepare($sql2);
    $stmt2->bind_param('s', $blood_bank_email);
    $stmt2->execute();
    $stmt2->bind_result($blood_bank_id);
    $stmt2->fetch();
    $stmt2->close();

    if ($donor_id) {
        $sql3 = "INSERT INTO Donation (donor_id, blood_bank_id, donation_date) VALUES (?, ?, ?)";
        $stmt3 = $link->prepare($sql3);
        $stmt3->bind_param('iis', $donor_id, $blood_bank_id, $donation_date);
        $stmt3->execute();
        $stmt3->close();
        $success_message = "Donation added successfully";
    } else {
        $error_email = "No donor found with that email.";
    }
}


$link->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../BloodAlert_logo.png">
    <title>Donor Dashboard</title>
    <link rel="stylesheet" href="../../stylesheet/reset.css">
    <link rel="stylesheet" href="../../stylesheet/styles2.css">

    <script>
        function validateForm() {
            document.getElementById('error-email').innerHTML = "";

            let email = document.forms["donation-form"]["email"].value;
            let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (email == "") {
                document.getElementById('error-email').innerHTML = "Email must be filled out";
                return false;
            } else if (!emailPattern.test(email)) {
                document.getElementById('error-email').innerHTML = "Please enter a valid email address";
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <header>
        <div class="logo-container">
        <a href="bbank_front_page.php">
            <img class="logo" src="../../Logo-and-text.png" alt="Logo"> </a>
        </div>
        <nav>
            <ul>
                <li class="active"><a href="bbank_register_donation.php">Register Donation</a></li>
                <li><a href="bbank_notification_log.php">Notification log</a></li>
                <li><a href="bbank_front_page.php">Inventory</a></li>
                <li><a href="bbank_info.php">Profile</a></li>
            </ul>
        </nav>
        <button>Log Out</button>
    </header>

    <main>
    <h1>Register Donation</h1>
    <div class="regdon-form-container">
        <form action="bbank_register_donation.php" method="POST" id="donation-form" onsubmit="return validateForm();">
            <div class="regdon-form-row">
                <div class="regdon-form-group-donor">  
                    <h4>Enter donor's email address:</h4>
                    <input type="email" id="email" name="email" required>
                    <div id="error-email" class="error-message">
                        <?php echo $error_email; ?>
                    </div>
                </div>
                
                <div class="regdon-form-group-donor">  
                    <h4>Date of donation:</h4>
                    <input type="date" id="donation-date" name="donation-date" required>
                </div>
            </div>
            
            <button class="add-donation-button-donor" type="submit">Add Donation</button>
            <?php if ($success_message): ?>
                <p class="success-message"><?php echo $success_message; ?></p>
            <?php endif; ?>
        </form>
    </div>
</main>
</body>

<footer>
    <p>&copy; 2024 Blood Alert</p>
    <nav>
      <a href="../about_us.php">About Us</a> |
      <a href="../integrity_policy.php">Integrity Policy</a> |
      <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
    </nav>
</footer>
</html>