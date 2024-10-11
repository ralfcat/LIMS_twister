<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../BloodAlert_logo.png">
    <title>Blood Bank front page</title>
    <link rel="stylesheet" href="../../stylesheet/reset.css">
    <link rel="stylesheet" href="../../stylesheet/styles2.css" />
    <!-- Removed unneeded <script> tag -->
</head>

<body>
    <header>
        <div class="logo-container">
            <img class="logo" src="../../Logo-and-text.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li class="active"><a href="bbank_notification_log.php">Notification log</a></li>
                <li><a href="bbank_front_page.php">Inventory</a></li>
                <li><a href="bbank_info.php">Profile</a></li>
            </ul>
        </nav>
        <button class="logout-button"><a href="bb_log_out.php">Log Out</a></button>
    </header>

    <main> <!-- Added <main> tag to encompass main content -->
        <h1>Notification Log</h1>

        <table class="notification-log">
            <tr>
                <th>Date</th>
                <th>Number of People Notified</th>
            </tr>
            <tr>
                <td>2024-10-01</td>
                <td>150</td>
            </tr>
            <tr>
                <td>2024-09-28</td>
                <td>230</td>
            </tr>
            <tr>
                <td>2024-09-25</td>
                <td>180</td>
            </tr>
            <tr>
                <td>2024-09-22</td>
                <td>210</td>
            </tr>
            <tr>
                <td>2024-09-20</td>
                <td>170</td>
            </tr>
            <tr>
                <td>2024-09-15</td>
                <td>190</td>
            </tr>
        </table>
    </main> 
    
</body>

<footer>
  <p>&copy; 2024 My Website</p>
  <nav>
    <a href="#about">About Us</a> |
    <a href="#integricity_policy">Integricity Policy</a> |
    <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
  </nav>
</footer>

</html>