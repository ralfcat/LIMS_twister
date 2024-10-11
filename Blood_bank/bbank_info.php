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
    'info_changed' => 'Profile information sucessfully changed'
];
// delete this
if (isset($messages[$_GET['msg']])) {

    $x = $messages[$_GET['msg']];
    echo "document.addEventListener('DOMContentLoaded', function() {";
    echo "console.log( 'there is a login error $x');";
    echo "let x = document.getElementById('msgs');";
    echo 'x.innerHTML = "' . htmlspecialchars($messages[$_GET['msgs']]) . '";';
    echo "});";
 
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
</head>

<body>
    <header>
        <div class="logo-container">
            <img class="logo" src="../../Logo-and-text.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="bbank_notification_log.php">Notification log</a></li>
                <li><a href="bbank_front_page.php">Inventory</a></li>
                <li class="active"><a href="bbank_info.php">Profile</a></li>
            </ul>
        </nav>
        <button class="logout-button"><a href = "bb_log_out.php">Log Out</a></button>
    </header>

    <main>
        <h1>Blood bank ID</h1>
        <form action="bbank_front_page_backend.php" method="post" class="form-bbank">
        <section class="donation-form">
        <p id="msgs"></p>
            <div class="form-container">

                <!-- Left Column -->
                <div class="form-column">
                    <h3>Name:</h3>
                    <input type="text" placeholder="Enter name" name = "new-name" value="<?php echo $account_info['name'] ?>">
                    <h3>Email:</h3>
                    <input type="text" placeholder="Enter email" name = "new-email" value='<?php echo $account_info['email'] ?>'>
                    <!-- <h3>Password:</h3>
                <input type="password" placeholder="Enter password">
                <h3>Repeat password:</h3>
                <input type="password" placeholder="Enter password"> -->
                    
                    <input type="hidden" name="to_do" value="update_bb_info" />
                        <button class="profile-changes-button">Save changes</button>
                    
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <h3>Region:</h3>
                    <select name="regions">

                        <?php
                        foreach ($regions as $region) {
                            $x = curr_region();
                            write_console("the curr region is $x");
                            if ($region == curr_region()){
                                echo "<option value = '$region' selected> $region </option>";

                            } else {
                                echo "<option value = '$region'> $region </option>";

                            }
                     
                            
                            
                        }
                        ?>

                    </select>
                    <p>Want to reset your password? <a href="">Click Here</a>.</p>
                </div>
                </form>




            </div>




        </section>
    </main>
</body>

<footer>
  <p>&copy; 2024 My Website</p>
  <nav>
    <a href="#about">About Us</a> |
    <a href="#services">Services</a> |
    <a href="#contact">Contact</a>
  </nav>
</footer>
</html>
</html>