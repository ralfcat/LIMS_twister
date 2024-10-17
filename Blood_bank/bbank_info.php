<?php

require_once 'bbank_front_page_backend.php';

use function FrontEnd\get_account_info as get_account_info;
use function FrontEnd\get_regions as get_regions;
use function FrontEnd\curr_region as curr_region;
use function FrontEnd\write_js as write_js;
use function FrontEnd\write_console as write_console;

error_reporting(E_ERROR | E_PARSE);
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

if (!isset($_SESSION['email'])) {
    header('Location: bbank_log_in.php?msg=login-required');
    exit;
}

$account_info = get_account_info();

$regions = get_regions();

$messages = [
    'login-required' => 'You need to be logged in to see the requested page',
    'logged-out' => 'Successfully logged out',
    'wrong-password' => 'You have entered the wrong password',
    'info_changed' => 'Profile information sucessfully changed',
    'info_unchanged' => 'An error occured and profile information was unchanged. PLease try again'
];
// delete this
if (isset($messages[$_GET['msg']])) {

    $x = $messages[$_GET['msg']];
    echo "<script> document.addEventListener('DOMContentLoaded', function() {";
    echo "let x = document.getElementById('msgs');";
    echo 'x.innerHTML = "' . htmlspecialchars($messages[$_GET['msg']]) . '";';
    echo "}); </script>";
    
}


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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
</head>

<body>
    <header>
        <div class="logo-container">
            <img class="logo" src="../../Logo-and-text.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="bbank_register_donation.php">Register Donation</a></li>
                <li><a href="bbank_notification_log.php">Notification log</a></li>
                <li><a href="bbank_front_page.php">Inventory</a></li>
                <li class="active"><a href="bbank_info.php">Profile</a></li>
            </ul>
        </nav>
        <button class="logout-button"><a href="bb_log_out.php">Log Out</a></button>
    </header>

    <main>
        <h1>Blood bank ID</h1>
        <form action="bbank_front_page_backend.php" method="post" class="form-bbank-info" onsubmit = "return validate_form();">
            <section class="donation-form">
        
                <div class="form-container">

                    <!-- Left Column -->
                    <div class="form-column">
                        <h3>Name:</h3>
                        <input type="text" placeholder="Enter name" name="new-name" value="<?php echo $account_info['name'] ?>">
                        <h3>Email:</h3>
                        <input type="text" id = "email" placeholder="Enter email" name="new-email" value='<?php echo $account_info['email'] ?>'>
                        <p class="error-message"><?php echo $error_password; ?></p>
                        
                        <h3>Password:</h3>
                    <input type="password" id="password" name="password" placeholder="Enter password">
                    <p class="error-message"><?php echo $error_password; ?></p>
                        <button class="profile-changes-button" type="button" onclick="togglePassword()">Show passwords</button>
                        <h3>New password:</h3>
                        <input type="password" id="repeat_password" name="repeat_password" placeholder="Repeat password">

                        <input type="hidden" name="to_do" value="update_bb_info" />
                        <button class="profile-changes-button">Save changes</button>
                        <br>
                       
                    <p class="success-message" id = "msgs"></p>
                    
                  
                    </div>

                    <!-- Right Column -->
                    <div class="form-column">
                        <h3>Region:</h3>
                        <select name="regions">

                            <?php
                            foreach ($regions as $region) {
                                $x = curr_region();
                    
                                if ($region == curr_region()) {
                                    echo "<option value = '$region' selected> $region </option>";
                                } else {
                                    echo "<option value = '$region'> $region </option>";
                                }
                            }
                            ?>

                        </select>

                    </div>
        </form>




        </div>




        </section>
    </main>
    </body>

<!-- <footer>
    <p>&copy; 2024 Blood Alert</p>
    <nav>
        <a href="../about_us.html">About Us</a> |
        <a href="../integrity_policy.html">Integrity Policy</a> |
        <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
    </nav>
</footer> -->


<script>
        function togglePassword() {
            var oldPasswordField = document.getElementById('password');
            var newPasswordField = document.getElementById('repeat_password');

            if (oldPasswordField.type === "password" || newPasswordField.type === "password") {
                oldPasswordField.type = "text";
                newPasswordField.type = "text";
                button.textContent = "Hide passwords";
            } else {
                oldPasswordField.type = "password";
                newPasswordField.type = "password";
                button.textContent = "Show passwords";
            }
        }
    
    
    function validate_form() {
        var new_pass = document.getElementById('password').value;
        var renew_pass = document.getElementById('repeat_password').value;
        var email = document.getElementById('email').value;
        var msg = document.getElementById('msgs');
        msg.innerHTML = '';

        let symbols = "!@#$%^&*()_+";
        symbols = [...symbols];

        if (new_pass.innerHTML != "") {
            if (renew_pass.innerHTML == "") {
                msg.innerHTML = "Please fill in both password fields";
                return false;
            }
            else if (new_pass != renew_pass) {
                msg.innerHTML = "Passwords must match";
                return false;

            }

        }

        if (new_pass.length < 6 || !symbols.some(s => new_pass.includes(s))) {
            msg.innerHTML = "Your password does not fulfil the password requirements:<br><ul><li>The password is too short (min. 6 characters)</li> <li>The password does not contain a symbol</li></ul>";
            return false;
        }
        if (!email.includes('@')) {
            msg.innerHTML = "Please enter a valid email";
            return false;
        }



    }
    </script>
    <script src="../graph/graph_functions.js"></script>

</html>

