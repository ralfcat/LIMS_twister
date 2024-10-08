<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="../../BloodAlert_logo.png">
    <title>Start Page</title>
    <link rel="stylesheet" href="../../stylesheet/reset.css" />
    <link rel="stylesheet" href="../../stylesheet/styles2.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
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

    <div class="main-container">
        <div class="reg-form-container">
        <h2>Create New Account</h2>
        <form name="create_account" action="/Donor/Donor_reg/create_account.php" method="POST">
        <input type="hidden" name="to_do" value="create_new" />
            <div class="input-group">
                <input type="text" id="fname" name="fname" placeholder="First Name" />
            </div>
            <div class="input-group">
                <input type="text" id="lname" name="lname" placeholder="Last Name" />
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Password" />
            </div>
            <button class="login_button">Sign Up</button>
        </form>

        <div class="new-user">
            <p>Already Registered? <a href="/Donor/Donor_login/donor_log_in.php">Log in here</a></p>
        </div>
        </div>

        <div class="second-column">
            <div class="quote">
            <p>
                <strong>Your blood can save lives.</strong> Register now, and we'll help you make a difference when it's needed most.
            </p>
            </div>

            <div class="graph">
                <select id="region-select" onchange="updateGraph();" style=new>
                <option value="">Select a region</option>
                </select>
                <canvas id="bloodStockChart" width="500" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Load external JavaScript file -->
    <script src="graph/graph_functions.js"></script>
</body>
</html>