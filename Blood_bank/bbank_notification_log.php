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
    <body>

<h2>Notification History</h2>

    <table class="notification-log"> <!--Obs: backend is needed here--->
        <tr>
            <th>Date</th>
            <th>Number of People Notified</th>
        </tr>
        <tr>
            <td>2024-10-01</td>
            <td>150</td>
        </tr>
        <tr>
            <td>2024-09-28</td>
            <td>230</td>
        </tr>
        <tr>
            <td>2024-09-25</td>
            <td>180</td>
        </tr>
        <tr>
            <td>2024-09-22</td>
            <td>210</td>
        </tr>
        <tr>
            <td>2024-09-20</td>
            <td>170</td>
        </tr>
        <tr>
            <td>2024-09-15</td>
            <td>190</td>
        </tr>
    </table>

    </body>

    </main>
    <!-- <iframe name="hiddenFrame" width="0" height="0"  style="display: none;"></iframe> -->

</body>