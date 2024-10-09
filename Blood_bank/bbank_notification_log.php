<?php

require_once 'bbank_front_page_backend.php';

use function FrontEnd\get_stock as get_stock;
use function FrontEnd\get_threshold as get_threshold;

use FrontEnd\BloodStock as BloodStock;

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

// User is not logged in 
// if (!isset($_SESSION['loggedin'])) {
//     header('Location: bbank_log_in.php?msg=login-required');
//     exit;

// }

// $email = $_SESSION['email'];
if (!isset($_SESSION['email'])) { 
    header('Location: bbank_log_in.php?msg=login-required');
    exit;

}
$current_levels = get_stock($email);
$call_lev = 'get_threshold';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../BloodAlert_logo.png">
    <title>Blood Bank front page</title>
    <link rel="stylesheet" href="../../stylesheet/reset.css">
    <link rel="stylesheet" href="../../stylesheet/styles2.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
    </script>
</head>

<body>
    <script>

    </script>
    <header>
        <div class="logo-container">
            <img class="logo" src="../../Logo-and-text.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li class="active"><a href="bbank_notification_log.php">Notification log</a></li>
                <li><a href="bbank_front_page.php">Inventory</a></li>
                <li><a href="bbank_info.php">Profile</a></li>
            </ul>
        </nav>
        <button class="logout-button"> <a href = "bb_log_out.php">Log Out</a></button>
    </header>
    <main>
        <h1>Notification Log</h1>

    </main>
    <!-- <iframe name="hiddenFrame" width="0" height="0"  style="display: none;"></iframe> -->

</body>