<?php

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
        <form action="/register_donation" method="POST"> <!--Backend must be implemented here-->
            <div class="regdon-form-row">
                <div class="regdon-form-group-donor">  
                    <h4> Enter donor's email address:</h4>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="regdon-form-group-donor">  
                    <h4>Date of donation:</h4>
                    <input type="date" id="donation-date" name="donation-date" required>
                </div>
            </div>
            
            <button class="add-donation-button-donor" type="submit">Add Donation</button>
        </form>
    </div>
</main>
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