<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../BloodAlert_logo.png">
    <title>Blood Bank front page</title>
    <link rel="stylesheet" href="../stylesheet/reset.css">
    <link rel="stylesheet" href="../stylesheet/styles2.css" />
</head>

<body>
<header>
        <div class="logo-container">
            <img class="logo" src="../../BloodAlert_logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li class="active"><a href="bbank_front_page.php">Inventory</a></li>
                <li><a href="../../bbank_info.php">Profile</a></li>
            </ul>
        </nav>
        <button class="logout-button">Log Out</button>
    </header>
    <main>
        <h1>Blood level inventory</h1>

        <div class="bbank-container"> <!-- New container -->
            <div class="Current_levels">
                <h2>Current Levels</h2> <!--Implement the graph based on inventory levels here-->
                <canvas id="myCanvas" width="500" height="400"></canvas> <!--Beginning of graph, we need to implement backend here-->
            </div>

            <form action="#" method="POST" class="form-bbank"> <!--We need to change this-->
                <h2>Notification Thresholds</h2>
                <div class="input-group">
                    <label>O+<input type="text" name="mname"></label>
                    <label>O- <input type="text" name="mname"></label>
                </div>
                <div class="input-group">
                    <label>A+<input type="text" name="mname"></label>
                    <label>A- <input type="text" name="mname"></label>
                </div>
                <div class="input-group">
                    <label>B+<input type="text" name="mname"></label>
                    <label>B- <input type="text" name="mname"></label>
                </div>
                <div class="input-group">
                    <label>AB+<input type="text" name="mname"></label>
                    <label> AB-<input type="text" name="mname"></label>
                </div>
                <input class="save-donation-button" type="submit" value="SAVE">
            </form>
        </div>

        <section class="donation-form-bbank">
            <h3>Bloodtype</h3>
            <input type="text" placeholder="Enter Blodtype"> <!--We should have a dropdown list here-->
            <h3>Units</h3>
            <input type="text" placeholder="Enter Units">
            <button class="add-donation-button">Add Donation</button>
        </section>
    </main>

</body>
