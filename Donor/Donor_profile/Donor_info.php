<?php
session_start();
if (!isset($_SESSION['donor_id'])) {
    //if the user is not logged in send them to the donor_login
    header("Location: /Donor/Donor_login/donor_log_in.php");
    exit();
}
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
    $donor_region = $user['address'];
    $donor_age = $user['age'];
    $donor_password = $user['password']; // Save the hashed password for later comparison
    $donor_id = $user['donor_id'];
}

$sql2 = "SELECT region FROM Region";
$result2 = $link->query($sql2);

if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        $regions[] = $row['region']; // Store regions in an array
    }
}

$error_password = "";
$success_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email']; 
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];
    $blood_type = $_POST['blood_type'];
    $sex = $_POST['sex'];
    $region = $_POST['region'];
    $password_salt = $password . $email;

    if (empty($password)) {
        $sql = "UPDATE Donor SET name = ?, email = ?, blood_type = ?, sex = ?, address = ? WHERE donor_id = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param('sssssi', $name, $email, $blood_type, $sex, $region, $donor_id);
        $stmt->execute();
        $success_message ="Information updated successfully";
    } else {
        if ($password == $repeat_password) {
            if (strlen($password) < 6) {
                $error_password = "Password should be at least 6 characters long";
            } else if (!preg_match('/[\'^£$%&*()}{@#~?!><>,|=_+¬-]/', $password)) {
                $error_password = "Password should contain a special symbol";
            } else {
                $hashed_password = hash('md5',$password_salt);
                $sql = "UPDATE Donor SET name = ?, email = ?, password = ?, blood_type = ?, sex = ?, address = ? WHERE donor_id = ?";
                $stmt = $link->prepare($sql);
                $stmt->bind_param('ssssssi', $name, $email, $hashed_password, $blood_type, $sex, $region, $donor_id);
                $stmt->execute();
                $success_message = "Information updated successfully";
            }
        } else {
            $error_password = "Passwords do not match";
        }
    }
    // Fetch the updated data from the database
    $sql = "SELECT * FROM Donor WHERE donor_id = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('i', $donor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $donor_name = $user['name'];
        $donor_email = $user['email'];
        $donor_blood_type = $user['blood_type']; 
        $donor_sex = $user['sex'];
        $donor_region = $user['address'];
        $donor_password = $user['password']; // Save the hashed password for later comparison
    }
}

$link->close();
$stmt->close();
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
            <a href="donor_front_page_backend.php">
                <img class="logo" src="/Logo-and-text.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="/Donor/Donor_profile/donor_front_page_backend.php">My Donations</a></li>
                <li class="active"><a href="donor_info.php">Profile</a></li>
            </ul>
        </nav>
        <button onclick="window.location.href='/Donor/Donor_login/donor_log_out.php';">Log Out</button> 
    </header>

 <main>
    <!-- SCRIPTS FOR SHOWING/HIDING PASSWORD-->
    <script>
        function togglePassword() {
            var oldPasswordField = document.getElementById('password');
            var newPasswordField = document.getElementById('repeat_password');

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
                    <input type="text" id="name" name="name" placeholder="Enter name" value="<?php echo $donor_name; ?>">
                    
                    <h3>Email:</h3>
                    <input type="text" id="email" name="email" placeholder="Enter email" value="<?php echo htmlspecialchars($donor_email); ?>">
                    <h3>Password:</h3>
                    <input type="password" id="password" name="password" placeholder="Enter password">
                    <p class="error-message"><?php echo $error_password; ?></p>
                    <button class = "profile-changes-button" type="button" onclick="togglePassword()">Show passwords</button>
                    <h3>New password:</h3>
                    <input type="password" id="repeat_password" name="repeat_password" placeholder="Repeat password">


                    <button class="profile-changes-button" type="submit">Save changes</button>
                    <br>
                    <?php if ($success_message): ?>
                    <p class="success-message"><?php echo $success_message; ?></p>
                    <?php endif; ?>

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

<footer>
  <p>&copy; 2024 Blood Alert</p>
  <nav>
    <a href="../../about_us.php">About Us</a> |
    <a href="../../integrity_policy.php">Integrity Policy</a> |
    <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
  </nav>
</footer>
</html>