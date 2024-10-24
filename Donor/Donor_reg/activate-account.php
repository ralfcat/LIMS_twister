<?php 
$token = $_GET["token"];
$token_hash = hash("md5", $token);
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "twister";

$link = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection is established
if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = 'SELECT * FROM Donor WHERE account_activation_hash = "' . $token_hash . '"';

$req = $link->query($sql);
$user = $req->fetch_assoc();

if ($user === null) {
    die('token not found');
}

$change_sql = "UPDATE Donor SET account_activation_hash = NULL WHERE donor_id = ? " ;
$stmt = $link->prepare($change_sql);
$stmt->bind_param("i", $user["donor_id"]);
$stmt->execute();   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="../../BloodAlert_logo.png">
    <title>Start Page</title>
    <link rel="stylesheet" href="../../stylesheet/reset.css" />
    <link rel="stylesheet" href="../../stylesheet/styles2.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
</head>

<body>
    <header>
        <div class="logo-container">
            <img class="logo" src="../../Logo-and-text.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="Donor/Donor_login/donor_log_in.php">Donor Login</a></li>
                <li><a href="Blood_bank/bbank_log_in.php">Blood Bank Login</a></li>
            </ul>
        </nav>
    </header>
    <div class="main-container">

<h1>Account Activated</h1> <br>
<p>Account activated successfully. You can now <a href="/Donor/Donor_login/donor_log_in.php">log in</a>.</p>
 </div>

 <footer>
  <p>&copy; 2024 Blood Alert</p>
  <nav>
    <a href="about_us.php">About Us</a> |
    <a href="integrity_policy.php">Integrity Policy</a> |
    <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
  </nav>
</footer>
</html>