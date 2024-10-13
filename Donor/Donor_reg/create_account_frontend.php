<?
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/BloodAlert_logo.png">
    <title>Fill out account</title>
    <link rel="stylesheet" href="/stylesheet/reset.css">
    <link rel="stylesheet" href="/stylesheet/styles2.css">
    
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
    <h1>Personal information</h1>
    <section class="donation-form">
        <form method="POST" action="donor_info.php">
            <div class="form-container">
                <!-- Left Column -->
                <div class="form-column">
                    <h3>Name:</h3>
                    <input type="text" id="name" name="name" placeholder="Enter name" value="<?php echo htmlspecialchars($donor_name); ?>">
                    
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
    <a href="../../about_us.html">About Us</a> |
    <a href="../../integrity_policy.html">Integrity Policy</a> |
    <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
  </nav>
</footer>
</html>