<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="BloodAlert_logo.png">
    <title>Donor Dashboard</title>
    <link rel="stylesheet" href="stylesheet/reset.css">
    <link rel="stylesheet" href="stylesheet/styles2.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img class="logo" src="Logo-and-text.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="bbank_notification_log.php">Notification log</a></li>
                <li><a href="Blood_bank/bbank_front_page.php">Inventory</a></li>
                <li class="active"><a href="bbank_info.php">Profile</a></li>
            </ul>
        </nav>
        <button>Log Out</button>
    </header>

    <main>
    <h1>Blood bank ID</h1>
    <section class="donation-form">
        <div class="form-container">
            <!-- Left Column -->
            <div class="form-column">
                <label for="name">Name</label>
                <input type="text" name="name" placeholder="Enter name">
                <label for="email">Email</label>
                <input type="text" name="email" placeholder="Enter email">
                <label for="password">Password</label>
                <input type="text" placeholder="Enter password">
                <label for="new-password">New password:</label>
                <input type="text" name="new-password" placeholder="Enter password">
            <button class="profile-changes-button">Save changes</button>
            </div>

            <!-- Right Column -->
            <div class="form-column">
                <h3>Region:</h3>
                <select name="Region">
                    <option value="" disabled selected>Select region</option>
                    <option value="Varmland">Värmland</option>
                    <option value="etc">etc</option>
                </select>
            </div>
        </div>

    </section>
</main>
</body>

</html>
<footer>
  <p>&copy; 2024 Blood Alert</p>
  <nav>
    <a href="about_us.html">About Us</a> |
    <a href="integrity_policy.html">Integrity Policy</a> |
    <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
  </nav>
</footer>