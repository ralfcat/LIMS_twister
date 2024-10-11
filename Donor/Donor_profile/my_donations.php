<?php
session_start();

if (!isset($_SESSION['email'])) {
    //if the user is not logged in send them to the donor_login
    header("Location: donor_log_in.php");
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
    header("Location: donor_log_in.php"); // if there is no result, then send them back since they dont have an account
    exit();
}

// Close the statement and connection
//

$stmt->close();
$link->close();
?>






<!-- !!! FRONT END !!! --> 
<!-- !!! FRONT END !!! -->   
<!-- !!! FRONT END !!! -->            
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blood Donor Log in</title>
    <link rel="stylesheet" href="../styles.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&display=swap">
    
</head>

<body>
    <div class="box">
        <p>Hello world 👽👽👽.</p>
        <!-- for logging out, put it where its needed! -->
        <a href="donor_log_out.php">Log out</a>
    </div>
</body>

<footer>
  <p>&copy; 2024 Blood Alert</p>
  <nav>
    <a href="#about">About Us</a> |
    <a href="#integricity_policy">Integricity Policy</a> |
    <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
  </nav>
</footer>
</html>
<!-- !!! FRONT END !!! --> 
<!-- !!! FRONT END !!! --> 
<!-- !!! FRONT END !!! --> 