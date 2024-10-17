<?php

require_once 'bbank_front_page_backend.php';

use function FrontEnd\get_stock as get_stock;
use function FrontEnd\get_threshold as get_threshold;
use function FrontEnd\get_regional_levels as get_regional_levels;
use function FrontEnd\write_js as write_js;
use function FrontEnd\get_rid as get_rid;
use function FrontEnd\curr_region as curr_region;

use FrontEnd\BloodStock as BloodStock;

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$messages = [
    'blood_info_unchanged' => 'Blood stock cannot be less than 0',
    'blood_stock_unchanged' => 'Blood stock cannot be less than 0'
];
if (isset($messages[$_GET['msg']])) {
    $err_msg = htmlspecialchars($messages[$_GET['msg']]);

    $js =  "document.addEventListener('DOMContentLoaded', function() {
     let x = document.getElementById('notif-message');
     x.innerHTML = ' $err_msg'; });";
    write_js($js);
}

if (!isset($_SESSION['email'])) {
    header('Location: bbank_log_in.php?msg=login-required');
    exit;
}
$current_levels = get_stock($email);
$call_lev = 'get_threshold';

$regional_levels = get_regional_levels();
$region = curr_region();

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
    </script>
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
                <li class="active"><a href="bbank_front_page.php">Inventory</a></li>
                <li><a href="bbank_info.php">Profile</a></li>
            </ul>
        </nav>
        <button> <a href="bb_log_out.php">Log Out</a></button>
    </header>
    <main>
        <h1>Blood level inventory</h1>
        <div class="bbank-container"> <!-- New container -->
            <div class="Current_levels">
            <h2>Current Blood Stock Levels</h2>
                <p id="notif-message"> </p>

                <div class="graph">
                    <canvas id="bloodStockChart" width="500" height="300"></canvas>

                    <select id="area-select" onchange="updateGraph('<?php echo $email; ?>', '<?php echo $region; ?>');" style="margin-top: 20px;">
                        <!-- <option value="" disabled selected>Change Area</option> -->
                        <option value="region" selected>Regional Levels</option>
                        <option value="local">Local Levels</option>
                        
                    </select>
                </div>

            </div>
        

            <form action="bbank_front_page_backend.php" method="POST" class="form-bbank">

                <input type="hidden" name="to_do" value="update_threshold" />
                <h2>Notification Thresholds</h2>

                <div class="input-group">
                    <label>O+<input type="text" name="O+" value=<?php echo get_threshold($current_levels, "O+"); ?>></label>
                    <label>O- <input type="text" name="O-" value=<?php echo get_threshold($current_levels, "O-"); ?>></label>
                </div>

                <div class="input-group">
                    <label>A+<input type="text" name="A+" value=<?php echo get_threshold($current_levels, "A+"); ?>></label>
                    <label>A- <input type="text" name="A-" value=<?php echo get_threshold($current_levels, "A-"); ?>></label>
                </div>

                <div class="input-group">
                    <label>B+<input type="text" name="B+" value=<?php echo get_threshold($current_levels, "B+"); ?>></label>
                    <label>B- <input type="text" name="B-" value=<?php echo get_threshold($current_levels, "B-"); ?>></label>
                </div>

                <div class="input-group">
                    <label>AB+<input type="text" name="AB+" value=<?php echo get_threshold($current_levels, "AB+"); ?>></label>
                    <label>AB- <input type="text" name="AB-" value=<?php echo get_threshold($current_levels, "AB-"); ?>></label>
                </div>

                <input class="save-donation-button" type="submit" value="Save changes"> 
            </form>
        </div>

        <section class="donation-form-bbank">
            <form method="POST" action="bbank_front_page_backend.php">
                <input type="hidden" name="to_do" value="update_blood" />
                <div class="form-row">
                    <div class="form-group-bbank">
                        <h3>Bloodtype</h3>
                        <select name="btypes" required>
                            <?php
                            foreach ($current_levels as $level) {
                                $type = htmlspecialchars($level->blood_type);
                                echo "<option value='$type'>$type</option>";
                            }
                            ?>
                        </select><br>
                    </div>
                    <div class="form-group-bbank">
                        <h3>Units</h3>
                        <input type="number" placeholder="Enter Units" name="units" required>
                    </div>
                </div>
                <button class="add-donation-button-bbank" type="submit" name="update" value="update">Update Levels</button>
            </form>
        </section>


    </main>
    <!-- <iframe name="hiddenFrame" width="0" height="0"  style="display: none;"></iframe> -->
    <script src="graphs/graph_functions.js"></script>
    <script>
        window.onload = function() {
            console.log('I am here');



            updateGraph('<?php echo $email; ?>','<?php echo $region; ?>' );
            console.log('I am now here');
        };
    </script>
   
</body>

<footer>
    <p>&copy; 2024 Blood Alert</p>
    <nav>
        <a href="../about_us.html">About Us</a> |
        <a href="../integrity_policy.html">Integrity Policy</a> |
        <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
    </nav>
</footer>