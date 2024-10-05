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
        <button class="logout-button">Log Out</button>
    </header>

    <main>
        <h1>My donations</h1>

        <section class="dashboard">
            <div class="donation-history">
                <h2>Donation History</h2>
                <ul>
                    <li>2024-02-29 Bloodcenter A</li>
                    <li>2023-08-24 Bloodcenter B</li>
                    <li>2022-12-18 Bloodcenter B</li>
                    <li>2022-05-25 Bloodcenter A</li>
                    <li>2021-09-23 Bloodcenter A</li>
                    <li>2021-02-24 Bloodcenter C</li>
                    <li>2020-06-20 Bloodcenter A</li>
                </ul>
            </div>

            <div class="upcoming-donations">
                <h2>Upcoming Donations</h2> <!--We need to add information here with backend if someone has upcoming donations-->
                <p>You don't have any upcoming donations, book a new appointment <a href="#">here</a>.</p>
            </div>
        </section>

        <section class="donation-form-bbank">
            <h3>Date of last donation</h3>
            <input type="text" placeholder="Enter name">
            <h3>Choose blood center</h3>
            <input type="text" placeholder="Enter blood center"> <!--We should have a dropdown list here-->
            <button class="add-donation-button">Add Donation</button>
        </section>
    </main>
</body>
</html>