<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Donor front page</title>
    <link rel="stylesheet" href="stylesheet/styles.css" />
    <link rel="stylesheet" href="stylesheet/reset.css" />
    <link href="BloodAlert_logo.png" rel="icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&display=swap">
</head>

<body>
    <header>
        <a href="donor_front_page.php"><img class="logo" src="BloodAlert_logo.png" alt="logo"></a>            

    <nav> <!--navigation-->
            <ul>
                <li class="active"><a href="donor_front_page.php">My donations</a></li>
                <li><a href="">Profile</a></li>
                <button class="logout-button" onclick="logout()">Log Out</button> <!--Add logout function-->
            </ul>
    </nav>
    </header>

    <div class="container">
        <div class="scrollmenu">
            <h2>Donation History</h2>
            <ul>
                <!--We need to add list items here with backend later-->
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
    <h2>Upcoming donations</h2>

    <?php if ($result->num_rows > 0): ?> <!--We need to add connection to database here-->
        <!-- If donations exist, display them in a table -->
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Location</th>
                </tr>
            </thead>
        </table>
    <?php else: ?>
        <!-- If no upcoming donations, display this message -->
        <p>You don’t have any upcoming donations,<br> 
            book a new appointment <a href="#">here</a>.
        </p>
    <?php endif; ?>

</div>
    </div>

    <form action="#" method="POST" class="donation-form"> <!--We need to chage this-->
        <div class="form-row">
            <div class="form-group">
                <label for="last-donation">Enter name of last donation:</label>
                <input type="text" name="mname" id="last-donation">
            </div>
            <div class="form-group">
                <label for="blood-center">Choose blood center:</label>
                <input type="text" name="myear" id="blood-center">
            </div>
        </div>
        <div class="submit-btn">
            <input type="submit" value="Add Donation">
        </div>
    </form>



</body>
