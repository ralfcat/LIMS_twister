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
                <li>Menu Item 1</li>
                <li>Menu Item 2</li>
            </ul>
        </div>

        <div class="upcoming-donations">
            <h2>Upcoming donations</h2>
            <p>You don’t have any upcoming donations,<br> 
                book a new appointment <a href="#">here</a>.
            </p>
        </div>
    </div>


    <form action="#" method="POST">  <!--We need to change this-->
        Enter name of last donation:<input type="text" name="mname"><br>
        Choose blood center:<input type="text" name="myear"><br> <!--We need to implement a selection list here with help of PHP-->
        <input type="submit" value="Add Donation">
    </form>



</body>
