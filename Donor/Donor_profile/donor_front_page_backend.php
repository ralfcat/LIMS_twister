<?php
session_start();
require_once '../../unsubscribe.php';

use function Unsubscribe\set_unsub_date;
use function Unsubscribe\get_unsub_date;
use function Unsubscribe\subscribe;


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

$email_ses = $_SESSION['email'];
$donor_id_ses = $_SESSION['donor_id'];





$sql = "SELECT * FROM Donor WHERE donor_id = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $donor_id_ses);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $donor_name = $user['name'];
    $donor_email = $user['email'];
    $donor_blood_type = $user['blood_type'];
    $donor_sex = $user['sex'];
    $donor_address = $user['address'];
    $donor_donation_date = $user['last_donation_date'];
    $donor_eligible = $user['is_eligible'];
    $donor_age = $user['age'];
    $donor_id = $user['donor_id'];
    $donor_unsubdate = $user['unsubscribe_date'];
    if (!isset($donor_unsubdate)) {
        $subscribed = true;
    } else {
        $subscribed = false;
    }

    $sql = "SELECT donation.donation_date, donation.amount, blood_bank.name FROM donation JOIN blood_bank ON donation.blood_bank_id = blood_bank.blood_bank_id WHERE donor_id = ? ORDER BY donation.donation_date DESC";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('i', $donor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $donations = [];

    $sql2 = "SELECT blood_bank_id, name FROM blood_bank";
    $result2 = $link->query($sql2);

    $blood_banks = [];
    if ($result2->num_rows > 0) {
        // Store blood banks in an array
        while ($row = $result2->fetch_assoc()) {
            $blood_banks[] = $row;
        }
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $donations[] = $row; // Store each donation row in the array
        }
    }
}

$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $to_do = $_POST["to_do"];


    if ($to_do == "unsubscribe") {
        $email = $email_ses;
        
        $date = $_POST["end-date"];

        set_unsub_date($email, $date);

        $donor_unsubdate = $date;
        $success_message = "Unsubscription date changed to $donor_unsubdate";
  
        $subscribed = false;
    } else if ($to_do == "resubscribe") {
        $email = $email_ses;

        
        subscribe($email);
        $success_message = "You are now subscribed to our mail list";

        $subscribed = true;

    }
    
    else {
        echo "<script> rmv_msg(); </script>";
        $donation_date = $_POST['donation_date'];
        $blood_center = $_POST['blood_center'];
        $amount = $_POST['amount'];

        $sql3 = "INSERT INTO Donation (donor_id, blood_bank_id, amount, donation_date) VALUES (?, ?, ?, ?)";

        $stmt = $link->prepare($sql3);
        $stmt->bind_param('iids', $donor_id, $blood_center, $amount, $donation_date);

        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}


$link->close();
$stmt->close();

?>

<!--Structure My donations page-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../BloodAlert_logo.png">
    <title>Donor Dashboard</title>
    <!--Reset file-->
    <link rel="stylesheet" href="../../stylesheet/reset.css">
    <link rel="stylesheet" href="../../stylesheet/styles2.css">
</head>

<body>
    <header> <!--Navigation-->
        <div class="logo-container">
            <a href="donor_front_page_backend.php">
                <img class="logo" src="../../Logo-and-text.png" alt="Logo"> </a>
        </div>
        <nav>
            <ul>
                <li class="active"><a href="donor_front_page_backend.php">My Donations</a></li>
                <li><a href="/donor/donor_profile/donor_info.php">Profile</a></li>
            </ul>
        </nav>
        <button onclick="window.location.href='/Donor/Donor_login/donor_log_out.php';">Log Out</button>
    </header>

    <main>
        <h1>My donations</h1>
        <?php if ($success_message): ?>
            <p class="success-message"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <section class="dashboard">
            <div class="donation-history">
                <h2>Donation History</h2>
                <?php if (!empty($donations)): ?>
                    <ul>
                        <?php foreach ($donations as $donation):

<<<<<<< HEAD
    <section class="dashboard">
        <div class="donation-history">  <!--View donation history-->
            <h2>Donation History</h2>
            <?php if (!empty($donations)): ?>
                <ul>
                    <?php foreach ($donations as $donation): 
         
=======
>>>>>>> d3499823c1eb784f681170a47b7e26069a9942f1
                            $curr_date = date("Y-m-d");
                            $don_date = $donation['donation_date'];

                            if ($don_date < $curr_date) {

<<<<<<< HEAD
        <div class="upcoming-donations" >  <!--View upcoming donations-->
            <h2>Upcoming Donations</h2> 
            <?php if (!empty($donations)): ?>
                <ul id="id01">
                    <?php foreach ($donations as $donation): 
         
=======
                        ?>
                                <li>
                                    <span><?php echo htmlspecialchars($donation['donation_date']); ?></span> -
                                    <span><?php echo htmlspecialchars($donation['name']); ?></span><br>
                                </li>
                        <?php }
                        endforeach; ?>
                    </ul>
                <?php else: ?>
                    <ul>
                        <li>No donation history available.
                        <li>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="upcoming-donations">
                <h2>Upcoming Donations</h2>
                <?php if (!empty($donations)): ?>
                    <ul id="id01">
                        <?php foreach ($donations as $donation):

>>>>>>> d3499823c1eb784f681170a47b7e26069a9942f1
                            $curr_date = date("Y-m-d");
                            $don_date = $donation['donation_date'];

                            if ($don_date >= $curr_date) {

                        ?>
                                <li>
                                    <span><?php echo htmlspecialchars($donation['donation_date']); ?></span> -
                                    <span><?php echo htmlspecialchars($donation['name']); ?></span><br>
                                </li>
                        <?php }
                        endforeach; ?>
                    </ul>
                <?php else: ?>
                    <ul>
                        <li>No upcoming donations.
                        <li>
<<<<<<< HEAD
                            <span><?php echo htmlspecialchars($donation['donation_date']); ?></span> - 
                            <span><?php echo htmlspecialchars($donation['name']); ?></span><br>
                        </li>
                    <?php }endforeach; ?>
                </ul>
            <?php else: ?>
                <ul>
                    <li>No upcoming donations.<li>
                </ul>
            <?php endif; ?>
        </div>
    </section>

<div class="forms-for-donation">  <!--Add previous donation - form-->
    <section class="donation-form-bbank">

    <form method="POST" action="donor_front_page_backend.php">
    <div class="form-row">
    <div class="form-group-donor">    
        <h3>Date of Last Donation</h3>        
        <input type="date" id="donation_date" max="<?php echo date("Y-m-d", strtotime('-1 day', time())); ?>" name="donation_date" required><br>
    </div>
    <div class="form-group-donor">    
            <h3>Choose Blood Center</h3>
            <select id="blood_center" name="blood_center" required>
                <option value="">Select a blood center</option>
                <?php foreach ($blood_banks as $bank): ?>
                    <option value="<?php echo htmlspecialchars($bank['blood_bank_id']); ?>">
                        <?php echo htmlspecialchars($bank['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
    </div>
    </div>

        <button class="add-donation-button-donor" type="submit">Add Donation</button>
    </form>
</section>


<section class="donation-form-bbank"> <!--Add upcoming donation - form-->

<form method="POST" action="donor_front_page_backend.php"> 
<div class="form-row">
<div class="form-group-donor">    
    <h3>Date of upcoming donation</h3>        
    <input type="date" id="donation_date" min="<?php echo date("Y-m-d"); ?>" name="donation_date" required ><br>
</div>
<div class="form-group-donor">    
        <h3>Choose Blood Center</h3>
        <select id="blood_center" name="blood_center" required>
            <option value="">Select a blood center</option>
            <?php foreach ($blood_banks as $bank): ?>
                <option value="<?php echo htmlspecialchars($bank['blood_bank_id']); ?>">
                    <?php echo htmlspecialchars($bank['name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>
</div>
</div>

    <button class="add-donation-button-donor" type="submit">Add Donation</button>
</form>
</section>
</div> <!--End forms for donation-->

 
<section class="unsubscribe"> <!--Unsubscribe from list-->
    <h2>Temporarily unsubscribe from our email list</h2>
    <p>By temporarily unsubscribing, you will not receive any updates about blood donation. This can be helpful if you have recently been pregnant, gotten a tattoo, or have other reasons that prevent you from donating for a while. </p>
    
    <form action="/unsubscribe" method="POST">
        <div class="unsub-form-row">
            <div class="unsub-form-group-donor">  
                <label for="email">Enter your email address:</label>
                <input type="email" id="email" name="email" required>
=======
                    </ul>
                <?php endif; ?>
>>>>>>> d3499823c1eb784f681170a47b7e26069a9942f1
            </div>
        </section>

        <div class="forms-for-donation">
            <!--Previous donations form-->
            <section class="donation-form-bbank">

                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-row">
                        <div class="form-group-donor">
                            <h3>Date of Last Donation</h3>
                            <input type="date" id="donation_date" max="<?php echo date("Y-m-d", strtotime('-1 day', time())); ?>" name="donation_date" required><br>
                        </div>
                        <div class="form-group-donor">
                            <h3>Choose Blood Center</h3>
                            <select id="blood_center" name="blood_center" required>
                                <option value="">Select a blood center</option>
                                <?php foreach ($blood_banks as $bank): ?>
                                    <option value="<?php echo htmlspecialchars($bank['blood_bank_id']); ?>">
                                        <?php echo htmlspecialchars($bank['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select><br>
                        </div>
                    </div>

                    <button class="add-donation-button-donor" type="submit">Add Donation</button>
                </form>
            </section>

            <!--Upcoming donations form-->
            <section class="donation-form-bbank">

                <form method="POST" action="donor_front_page_backend.php"> <!--We need to change backend here-->
                    <div class="form-row">
                        <div class="form-group-donor">
                            <h3>Date of upcoming donation</h3>
                            <input type="date" id="donation_date" min="<?php echo date("Y-m-d"); ?>" name="donation_date" required><br>
                        </div>
                        <div class="form-group-donor">
                            <h3>Choose Blood Center</h3>
                            <select id="blood_center" name="blood_center" required>
                                <option value="">Select a blood center</option>
                                <?php foreach ($blood_banks as $bank): ?>
                                    <option value="<?php echo htmlspecialchars($bank['blood_bank_id']); ?>">
                                        <?php echo htmlspecialchars($bank['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select><br>
                        </div>
                    </div>

                    <button class="add-donation-button-donor" type="submit">Add Donation</button>
                </form>
            </section>
        </div> <!--End forms for donation-->

        <?php if ($subscribed): ?>

            <!-- start here -->

            <section class="unsubscribe">
                <h2>Temporarily unsubscribe from our email list</h2>
                <p id="unsub_des">By temporarily unsubscribing, you will not receive any updates about blood donation. This can be helpful if you have recently been pregnant, gotten a tattoo, or have other reasons that prevent you from donating for a while. </p>

                    <p>You are currently subscribed to our mail list </p>
            



                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"> <!--Backend must be implemented here-->
                    <input type="hidden" name="to_do" value="unsubscribe" />
                    <div class="unsub-form-row">


                        <div class="unsub-form-group-donor">
                            <label for="end-date">End date of temporary unsubscription:</label>
                            <input type="date" id="end-date" name="end-date" min="<?php echo date("Y-m-d"); ?>" required>
                        </div>
                    </div>

                    <label class="unsub-confirmation">
                        <input type="checkbox" name="confirm" required>
                        <p>I confirm that I want to temporarily unsubscribe.</p>
                    </label>

                    <button class="add-donation-button-donor" type="submit">Unsubscribe</button>
                </form>
            </section>

        <?php elseif (!$subscribed): ?>
            <section class="unsubscribe">
                <h2>Resubscribe to our email list</h2>
                <p id="unsub_des"> By subscribing, you will receive any updates about blood donation. </p>
               
             
                    <p> You are currently unsubscribed from our email list until: <?php echo $donor_unsubdate; ?></p>
            



                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"> <!--Backend must be implemented here-->
                    <input type="hidden" name="to_do" value="resubscribe" />


                    <label class="unsub-confirmation">
                        <input type="checkbox" name="confirm" required>
                        <p>I confirm that I want to resubscribe.</p>
                    </label>

                    <button class="add-donation-button-donor" type="submit">Subscribe</button>
                </form>
            </section>
            <!-- end here -->
        <?php endif; ?>


    </main>

</body>

<<<<<<< HEAD
<footer> <!--Footer-->
  <p>&copy; 2024 Blood Alert</p>
  <nav>
    <a href="../../about_us.html">About Us</a> |
    <a href="../../integrity_policy.html">Integrity Policy</a> |
    <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
  </nav>
=======
<footer>
    <p>&copy; 2024 Blood Alert</p>
    <nav>
        <a href="../../about_us.php">About Us</a> |
        <a href="../../integrity_policy.php">Integrity Policy</a> |
        <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
    </nav>
>>>>>>> d3499823c1eb784f681170a47b7e26069a9942f1
</footer>



</html>