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
        <div class="logo-container">
            <img class="logo" src="../../BloodAlert_logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="donor_front_page_backend.php">My Donations</a></li>
                <li><a href="../../Donor_info.php">Profile</a></li>
            </ul>
        </nav>
        <button class="logout-button">Log Out</button>
    </header>

    <main>
        <h1>My donations</h1>

        <section class="dashboard">
            <div class="donation-history">
                <h2>Donation History</h2>
                <ul>
                    <li>Item 1</li>
                    <li>Item 2</li>
                    <li>Item 3</li>
                    <li>Item 4</li>
                    <li>Item 5</li>
                    <li>Item 6</li>
                    <li>Item 7</li>
                </ul>
            </div>

            <div class="upcoming-donations">
                <h2>Upcoming Donations</h2>
                <p>You don't have any upcoming donations, book a new appointment <a href="#">here</a>.</p>
            </div>
        </section>

        <section class="donation-form">
            <h3>Enter name of last donation:</h3>
            <input type="text" placeholder="Enter name">
            <h3>Choose blood center:</h3>
            <input type="text" placeholder="Enter blood center">
            <button class="add-donation-button">Add Donation</button>
        </section>
    </main>
</body>
</html>