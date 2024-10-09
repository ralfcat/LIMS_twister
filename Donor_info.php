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
                <li><a href="Donor/Donor_profile/donor_front_page_backend.php">My Donations</a></li>
                <li class="active"><a href="donor_info.php">Profile</a></li>
            </ul>
        </nav>
        <button class="logout-button">Log Out</button>
    </header>

    <main>
    <h1>Donor ID</h1>
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
                <button class="profile-changes-button">Save changes</button>

            </div>

            <!-- Right Column -->
            <div class="form-column">
                <h3>Blood type:</h3>
                <select name="btype">
                    <option value="" disabled selected>Select your blood type</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                </select>

                <h3>Sex:</h3>
                <select name="sex">
                    <option value="" disabled selected>Select your sex</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>

                <h3>Region:</h3>
                <select name="Region">
                    <option value="" disabled selected>Select your region</option>
                    <option value="Varmland">Värmland</option>
                    <option value="etc">etc</option>
                </select>
            </div>
        </div>
    </section>
</main>
</body>
</html>