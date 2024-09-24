<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blood Bank front page</title>
    <link href="BloodAlert_logo.png" rel="icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&display=swap">
</head>

<body>
    <header>
        <a href="bbank_front_page.php"><img class="logo" src="BloodAlert_logo.png" alt="logo"></a>            
    
    <nav> <!--navigation-->
            <ul>
                <li class="active"><a href="bbank_front_page.php">Blood level inventory</a></li>
                <li><a href="">Profile</a></li>
                <button class="logout-button" onclick="logout()">Log Out</button> <!--Add logout function-->
            </ul>
    </nav>
    </header>

    <div class="Current_levels">
           <h2>Current levels</h2>

    </div>

    <form action="#" method="POST"> <!--We need to change this-->
        <h2>Notification thresholds</h2>
        0+:<input type="text" name="mname"><br>
        0-:<input type="text" name="mname"><br>
        A+:<input type="text" name="mname"><br>
        A-:<input type="text" name="mname"><br>
        B+:<input type="text" name="mname"><br>
        B-:<input type="text" name="mname"><br>
        AB+:<input type="text" name="mname"><br>
        AB-:<input type="text" name="mname"><br>
        <input type="submit" value="SAVE">
    </form>

    <form action="#" method="POST">  <!--We need to change this-->
        Blood type:<input type="text" name="mname"><br>
        Units:<input type="text" name="myear"><br> 
        <input type="submit" value="Update levels">
    </form>

</body>
