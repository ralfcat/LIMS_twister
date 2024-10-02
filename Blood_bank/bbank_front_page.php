<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../BloodAlert_logo.png">
    <title>Blood Bank front page</title>
    <link rel="stylesheet" href="../stylesheet/styles.css" />
</head>

<body>
    <header>
    <div class="logo-container">
            <img class="logo" src="../../BloodAlert_logo.png" alt="Logo">
        </div>       
        <nav> <!--navigation-->
            <ul>
                <li><a class="active"><a href="bbank_front_page.php">Blood level inventory</a></li>
                <li><a href="../bbank_info.php">Profile</a></li>
            </ul>
        </nav>
    <button class="logout-button" onclick="logout()">Log Out</button> <!--Add logout function-->

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
                    <label>0+:<input type="text" name="mname"></label>
                    <label>0-:<input type="text" name="mname"></label>
                </div>
                <div class="input-group">
                    <label>A+:<input type="text" name="mname"></label>
                    <label>A-:<input type="text" name="mname"></label>
                </div>
                <div class="input-group">
                    <label>B+:<input type="text" name="mname"></label>
                    <label>B-:<input type="text" name="mname"></label>
                </div>
                <div class="input-group">
                    <label>AB+:<input type="text" name="mname"></label>
                    <label>AB-:<input type="text" name="mname"></label>
                </div>
                <input class="add-donation-button" type="submit" value="SAVE">
            </form>
        </div>
    </main>

    <section class="donation-form-bbank">
            <h3>Bloodtype:</h3>
            <input type="text" placeholder="Enter name">
            <h3>Units:</h3>
            <input type="text" placeholder="Enter blood center">
            <button class="add-donation-button">Add Donation</button>
        </section>

</body>
