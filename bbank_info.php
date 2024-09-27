<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="BloodAlert_logo.png">
    <title>Donor Dashboard</title>
    <link rel="stylesheet" href="stylesheet/styles.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img class="logo" src="BloodAlert_logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="bbank_front_page.php">Blood level inventory</a></li>
                <li><a href="bbank_info.php">Profile</a></li>
            </ul>
        </nav>
        <button class="logout-button">Log Out</button>
    </header>

    <main>
    <h1>Blood bank ID</h1>
    <section class="donation-form">
        <div class="form-container">
            <!-- Left Column -->
            <div class="form-column">
                <h3>Name:</h3>
                <input type="text" placeholder="Enter name">
                <h3>Email:</h3>
                <input type="text" placeholder="Enter email">
                <h3>Password:</h3>
                <input type="text" placeholder="Enter password">
                <h3>Repeat password:</h3>
                <input type="text" placeholder="Enter password">
            </div>

            <!-- Right Column -->
            <div class="form-column">
                <h3>Region:</h3>
                <input type="text" placeholder="Region">
            </div>
        </div>
        <button class="profile-changes-button">Save changes</button>
    </section>
</main>
</body>
</html>