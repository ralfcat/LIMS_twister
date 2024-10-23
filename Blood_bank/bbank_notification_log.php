<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "twister";

// Create connection
$link = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection is established
if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch blood bank ID using the email from the session
$blood_bank_email = $_SESSION['email'];
$sql = "SELECT blood_bank_id FROM Blood_Bank WHERE email = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param('s', $blood_bank_email);
$stmt->execute();
$stmt->bind_result($blood_bank_id);
$stmt->fetch();
$stmt->close();

// Fetch notification logs
$sql = "SELECT notification_date, COUNT(donor_id) AS number_notified 
        FROM Notification 
        WHERE blood_bank_id = ? 
        GROUP BY notification_date
        ORDER BY notification_date DESC";
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $blood_bank_id);
$stmt->execute();
$result = $stmt->get_result();

$notification_logs = [];
while ($row = $result->fetch_assoc()) {
    $notification_logs[] = $row;
}

$stmt->close();
$link->close();
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
    <!-- Removed unneeded <script> tag -->
</head>

<body>
    <header>
        <div class="logo-container">
        <a href="bbank_front_page.php"> 
            <img class="logo" src="../../Logo-and-text.png" alt="Logo"></a>
        </div>
        <nav>
            <ul>
                <li><a href="bbank_register_donation.php">Register Donation</a></li>
                <li class="active"><a href="bbank_notification_log.php">Notification log</a></li>
                <li><a href="bbank_front_page.php">Inventory</a></li>
                <li><a href="bbank_info.php">Profile</a></li>
            </ul>
        </nav>
        <button><a href="bb_log_out.php">Log Out</a></button>
    </header>

    <main>
        <h1>Notification Log</h1>
        <section class="notification-log">
            <table class="notification-log">
                <tr>
                    <th>Date</th>
                    <th>Number of People Notified</th>
                </tr>
                <?php foreach ($notification_logs as $log): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($log['notification_date']); ?></td>
                        <td><?php echo htmlspecialchars($log['number_notified']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </main>
    
</body>

<footer>
  <p>&copy; 2024 Blood Alert</p>
  <nav>
    <a href="../about_us.php">About Us</a> |
    <a href="../integrity_policy.php">Integrity Policy</a> |
    <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
  </nav>
</footer>

</html>