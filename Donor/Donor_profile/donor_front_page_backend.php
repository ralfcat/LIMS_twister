<?php
session_start();


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
        while($row = $result2->fetch_assoc()) {
            $blood_banks[] = $row;
        }
    }
        
    if ($result->num_rows > 0) { 
        while ($row = $result->fetch_assoc()) {
            $donations[] = $row; // Store each donation row in the array
        }
            } 

}

 //Close the statement and connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
                <li class="active"><a href="donor_front_page_backend.php">My Donations</a></li>
                <li><a href="../../donor_info.php">Profile</a></li>
            </ul>
        </nav>
        <button class="logout-button" onclick="window.location.href='/Donor/Donor_login/donor_log_out.php';">Log Out</button>   
    </header>

    <main>
    <h1>My donations</h1>

    <section class="dashboard">
        <div class="donation-history">
            <h2>Donation History</h2>
            <?php if (!empty($donations)): ?>
                <ul>
                    <?php foreach ($donations as $donation): ?>
                        <li>
                            <span><?php echo htmlspecialchars($donation['donation_date']); ?></span> - 
                            <span><?php echo htmlspecialchars($donation['name']); ?></span><br>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <ul>
                    <li>No donation history available.<li>
                </ul>
            <?php endif; ?>
        </div>

        <div class="upcoming-donations" >
            <h2>Upcoming Donations</h2>
            <p>You don't have any upcoming donations, book a new appointment <a href="#">here</a>.</p>
        </div>
    </section>

    <section class="donation-form-bbank">

    <h3>Date of Last Donation</h3>
    <form method="POST" action="donor_front_page_backend.php">
        <input type="date" id="donation_date" name="donation_date" required><br>

        <h3>Choose Blood Center</h3>
        <select id="blood_center" name="blood_center" required>
            <option value="">Select a blood center</option>
            <?php foreach ($blood_banks as $bank): ?>
                <option value="<?php echo htmlspecialchars($bank['blood_bank_id']); ?>">
                    <?php echo htmlspecialchars($bank['name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <button class="add-donation-button" type="submit">Add Donation</button>
    </form>
</section>
</main>
</body>
</html>