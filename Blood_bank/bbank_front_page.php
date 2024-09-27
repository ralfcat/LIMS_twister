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
        <a href="bbank_front_page.php"><img class="logo" src="../BloodAlert_logo.png" alt="logo"></a>            
    
    <nav> <!--navigation-->
            <ul>
                <li class="active"><a href="bbank_front_page.php">Blood level inventory</a></li>
                <li><a href="../bbank_info.php">Profile</a></li>
                <li><button class="logout-button" onclick="logout()">Log Out</button></li> <!--Add logout function-->
            </ul>
    </nav>
    </header>

    <div class="bbank-container"> <!-- New container -->
        <div class="Current_levels">
            <h2>Current Levels</h2>
        </div>

        <form action="#" method="POST"> <!--We need to change this-->
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
            <input type="submit" value="SAVE">
        </form>
    </div>

    <form action="#" method="POST" class="donation-form"> <!--We need to chage this-->
        <div class="form-row">
            <div class="form-group">
                <label for="last-donation">Bloodtype:</label>
                <input type="text" name="mname" id="last-donation">
            </div>
            <div class="form-group">
                <label for="blood-center">Units:</label>
                <input type="text" name="myear" id="blood-center">
            </div>
        </div>
        <div class="submit-btn">
            <input type="submit" value="Update levels">
        </div>
    </form>

</body>
