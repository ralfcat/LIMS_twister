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
                <li class="active"><a href="bbank_front_page.php">Inventory</a></li>
                <li><a href="bbank_info.php">Profile</a></li>
            </ul>
        </nav>
        <button class="logout-button"> <a href = "bb_log_out.php">Log Out</a></button>
    </header>
    <main>
        <h1>Blood level inventory</h1>

        <div class="bbank-container"> <!-- New container -->
            <div class="Current_levels">
                <h2>Current Levels</h2> <!--Implement the graph based on inventory levels here-->
                <h4>To be replaced with a graph</h4>
                <table>
                    <tr>
                        <th>Blood Type</th>
                        <th>Current Level</th>
                        <th>Current Threshold</th>
                    </tr>
                    <?php

                    foreach ($current_levels as $level) {
                        $type = $level->blood_type;
                        $stock = $level->current_stock;
                        $thres = $level->thres_level;
                        echo "<tr><td>$type</td><td>$stock</td><td>$thres</td></tr>";
                    }

                    ?>
                </table>

                <canvas id="myCanvas" width="500" height="400"></canvas> <!--Beginning of graph, we need to implement backend here-->

            </div>

            <form action="bbank_front_page_backend.php" method="POST" class="form-bbank"> <!--We need to change this-->
            <input type="hidden" name="to_do" value="update_threshold" />
                <input type='hidden' name='mid' value=''>
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
                    <label>AB+<input type="text" name="mname" value=<?php echo get_threshold($current_levels, "AB+"); ?>></label>
                    <label> AB-<input type="text" name="mname" value=<?php echo get_threshold($current_levels, "AB-"); ?>></label>
                </div>
                <input class="save-donation-button" type="submit" value="SAVE">
            </form>
        </div>

        <section class="donation-form-bbank">
        <form action="bbank_front_page_backend.php" method="post">
        <input type="hidden" name="to_do" value="update_blood" />
            <h3>Bloodtype</h3>
            <select name="btypes">

                <?php
                foreach ($current_levels as $level) {
                    $type = $level->blood_type;
                    $stock = $level->current_stock;
                    $thres = $level->thres_level;
                    echo "<option value = '$type'> $type </option>";
                }
                ?>

            </select>
            <h3>Units</h3>
            <input type="number" placeholder="Enter Units" name = "units">
            <!-- I changed Add Donation to Update Levels so that the blood bank can input negative values to remove blood from their stock  -->
            <button class="add-donation-button" name="update" value="update">Update Levels</button>
            </form>
        </section>
    </main>
    <!-- <iframe name="hiddenFrame" width="0" height="0"  style="display: none;"></iframe> -->

</body>