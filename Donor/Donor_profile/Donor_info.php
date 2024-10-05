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
    $donor_region = $user['address'];
    $donor_age = $user['age'];
    $donor_id = $user['donor_id'];

}


$sql2 = "SELECT region FROM Region";
$result2 = $link->query($sql2);

if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        $regions[] = $row['region']; // Store regions in an array
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email']; 
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $blood_type = $_POST['blood_type'];
    $sex = $_POST['sex'];
    $date_of_birth = $_POST['date_of_birth'];
    $region = $_POST['region'];
}

//$stmt->close();
$link->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/BloodAlert_logo.png">
    <title>Donor Dashboard</title>
    <link rel="stylesheet" href="/stylesheet/reset.css">
    <link rel="stylesheet" href="/stylesheet/styles2.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img class="logo" src="/BloodAlert_logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="/Donor/Donor_profile/donor_front_page_backend.php">My Donations</a></li>
                <li class="active"><a href="donor_info.php">Profile</a></li>
            </ul>
        </nav>
        <button class="logout-button">Log Out</button>
    </header>

    <main>
    <!-- SCRIPTS FOR SHOWING/HIDING PASSWORD-->
    <script>
        function togglePassword() {
            var oldPasswordField = document.getElementById('old_password');
            var newPasswordField = document.getElementById('new_password');

            if (oldPasswordField.type === "password" || newPasswordField.type === "password") {
                oldPasswordField.type = "text";
                newPasswordField.type = "text";
                button.textContent = "Hide passwords";
            } else {
                oldPasswordField.type = "password";
                newPasswordField.type = "password";
                button.textContent = "Show passwords";
            }
        }
    </script>
    <!-- SCRIPTS FOR SHOWING/HIDING PASSWORD-->
    <h1>Donor ID</h1>
    <section class="donation-form">
        <form method="POST" action="donor_info.php">
            <div class="form-container">
                <!-- Left Column -->
                <div class="form-column">
                    <h3>Name:</h3>
                    <input type="text" id="name" name="name" placeholder="Enter name" value="<?php echo htmlspecialchars($donor_name); ?>">
                    
                    <h3>Email:</h3>
                    <input type="text" id="email" name="email" placeholder="Enter email" value="<?php echo htmlspecialchars($donor_email); ?>">
                    
                    <h3>Old password:</h3>
                    <input type="password" id="old_password" name="old_password" placeholder="Enter old password">
                    
                    <h3>New password:</h3>
                    <input type="password" id="new_password" name="new_password" placeholder="Enter new password">
                    <h3>Confirm new password:</h3>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm  new password">
                    <button type="button" onclick="togglePassword()">Show passwords</button>

                    <button class="profile-changes-button" type="submit">Save changes</button>
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <h3>Blood type:</h3>
                    <select name="blood_type">
                        <option value="" disabled>Select your blood type</option>
                        <option value="O+" <?php if($donor_blood_type == 'O+') echo 'selected'; ?>>O+</option>
                        <option value="O-" <?php if($donor_blood_type == 'O-') echo 'selected'; ?>>O-</option>
                        <option value="A+" <?php if($donor_blood_type == 'A+') echo 'selected'; ?>>A+</option>
                        <option value="A-" <?php if($donor_blood_type == 'A-') echo 'selected'; ?>>A-</option>
                        <option value="B+" <?php if($donor_blood_type == 'B+') echo 'selected'; ?>>B+</option>
                        <option value="B-" <?php if($donor_blood_type == 'B-') echo 'selected'; ?>>B-</option>
                        <option value="AB+" <?php if($donor_blood_type == 'AB+') echo 'selected'; ?>>AB+</option>
                        <option value="AB-" <?php if($donor_blood_type == 'AB-') echo 'selected'; ?>>AB-</option>
                    </select>

                    <h3>Sex:</h3>
                    <select name="sex">
                        <option value="" disabled>Select your sex</option>
                        <option value="Male" <?php if($donor_sex == 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if($donor_sex == 'Female') echo 'selected'; ?>>Female</option>
                        <option value="Other" <?php if($donor_sex == 'Other') echo 'selected'; ?>>Other</option>
                    </select>

                    <h3>Date of birth:</h3>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($donor_age); ?>">

                    <h3>Region:</h3>
                    <select name="region">
                    <option value="" disabled>Select your region</option>
                    <?php foreach ($regions as $region): ?>
                        <option value="<?php echo htmlspecialchars($region); ?>" <?php if($region == $donor_region) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($region); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                </div>
            </div>
        </form>
    </section>
</main>
</body>
</html>