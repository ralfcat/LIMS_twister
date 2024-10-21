<?php
session_start();

if (!isset($_SESSION['email'])) {
    //if the user is not logged in send them to the donor_login
    header("Location: /Donor/Donor_login/donor_log_in.php");
    exit();
}

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


$email = $_SESSION['email'];



$sql = "SELECT * FROM Donor WHERE email = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param('s', $email);
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

    $sql = "SELECT donation.donation_date, donation.amount, blood_bank.name FROM donation JOIN blood_bank ON donation.blood_bank_id = blood_bank.blood_bank_id WHERE donor_id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('i', $donor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $donations = [];
    if ($result->num_rows > 0) { 
        while ($row = $result->fetch_assoc()) {
            $donations[] = $row; // Store each donation row in the array
        }
    
} }
else {
    header("Location: Donor/Donor_login/donor_log_in.php"); // if there is no result, then send them back since they dont have an account
    exit();
}

// Close the statement and connection
//

$stmt->close();
$link->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../BloodAlert_logo.png">
    <title>Donor Dashboard</title>
    <link rel="stylesheet" href="../../stylesheet/styles.css">
</head>

<body>
    <header>
        <a href="donor_front_page.php"><img class="logo" src="/BloodAlert_logo.png" alt="logo"></a>            

    <nav> <!--navigation-->
            <ul>
                <li class="active"><a href="donor_front_page.php">My donations</a></li>
                <li><a href="">Profile</a></li>
                <button onclick="window.location.href='/Donor/Donor_login/donor_log_out.php';">Log Out</button>
            </ul>
    </nav>
    </header>

    <div class="container">
        <div class="scrollmenu">
            <h2>Donation History</h2>
            <?php if (!empty($donations)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Blood Bank</th>
                            <th>Amount (liters)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($donations as $donation):  
                           
                            
                            if (strtotime($don_date) < strtotime($curr_date)) {
                                
                                $date = $donation['donation_date'];
                                $name = $donation['name'];
                                $am = $donation['amount'];

                                echo "<tr>
                                <td>$date</td>
                                <td>$name></td>
                                <td>$am </td>
                            </tr>";
                            
                            ?>
                            
                        <?php  }endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No donation history available.</p>
            <?php endif; ?>
        </div>

        <div class="upcoming-donations">
    <h2>Upcoming donations</h2>

    <?php if ($result->num_rows > 0): ?> <!--We need to add connection to database here-->
        <!-- If donations exist, display them in a table -->
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Location</th>
                </tr>
            </thead>
        </table>
    <?php else: ?>
        <!-- If no upcoming donations, display this message -->
        <p>You don’t have any upcoming donations,<br> 
            book a new appointment <a href="#">here</a>.
        </p>
    <?php endif; ?>

</div>
    </div>

    <form action="#" method="POST" class="donation-form"> <!--We need to change action here-->
        <div class="form-row">
            <div class="form-group">
                <label for="last-donation">Enter name of last donation:</label>
                <input type="text" name="mname" id="last-donation">
            </div>
            <div class="form-group">
                <label for="blood-center">Choose blood center:</label>
                <input type="text" name="myear" id="blood-center">
            </div>
        </div>
        <div class="submit-btn">
            <input type="submit" value="Add Donation">
        </div>
    </form>



</body>
<footer>
  <p>&copy; 2024 Blood Alert</p>
  <nav>
    <a href="../../about_us.php">About Us</a> |
    <a href="../../integrity_policy.php">Integrity Policy</a> |
    <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
  </nav>
</footer>