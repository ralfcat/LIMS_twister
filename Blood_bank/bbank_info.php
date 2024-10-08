<?php

require_once 'bbank_front_page_backend.php';

use function FrontEnd\get_account_info as get_account_info;
use function FrontEnd\get_regions as get_regions;
use function FrontEnd\write_js as write_js;

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$account_info = get_account_info();

$regions = get_regions();


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
                <li><a href="bbank_front_page.php">Inventory</a></li>
                <li class="active"><a href="bbank_info.php">Profile</a></li>
            </ul>
        </nav>
        <button class="logout-button">Log Out</button>
    </header>

    <main>
        <h1>Blood bank ID</h1>
        <section class="donation-form">
            <div class="form-container">
                <!-- Left Column -->
                <div class="form-column">
                    <h3>Name:</h3>
                    <input type="text" placeholder="Enter name" value='<?php echo $account_info['name'] ?>'>
                    <h3>Email:</h3>
                    <input type="text" placeholder="Enter email" value='<?php echo $account_info['email'] ?>'>
                    <!-- <h3>Password:</h3>
                <input type="password" placeholder="Enter password">
                <h3>Repeat password:</h3>
                <input type="password" placeholder="Enter password"> -->
                    <button class="profile-changes-button">Save changes</button>
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <h3>Region:</h3>
                    <select name="regions">

                        <?php
                        foreach ($regions as $region) {
                            $name = $region;
                            write_js("console.log('The region is $name')");
                            echo "<option value = '$name'> $name </option>";
                        }
                        ?>

                    </select>
                    <p>Want to reset your password? <a href="">Click Here</a>.</p>
                </div>




            </div>




        </section>
    </main>
</body>

</html>