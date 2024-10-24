<?php
session_start();
$frontpage = "";
if (isset($_SESSION['bbloggedin'])) {
    $frontpage = "Blood_bank/bbank_front_page.php";
} else if (isset($_SESSION['donorlogged'])) {
    $frontpage = "Donor/Donor_profile/donor_front_page_backend.php";
} else {
    $frontpage = "index.php";
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="../../BloodAlert_logo.png">
    <title>Donor Login</title>
    <link rel="stylesheet" href="../../stylesheet/reset.css" />
    <link rel="stylesheet" href="../../stylesheet/styles2.css" />
    <script>
        function validateForm() {
            let email = document.forms["loginform"]["email"].value;
            let password = document.forms["loginform"]["password"].value;
            
            let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            
            document.getElementById("error-message").innerHTML = "";
            document.getElementById("error-message2").innerHTML = "";
            if (email == "") {
                document.getElementById("error-message").innerHTML = "Email must be filled out";
                document.getElementById("error-message").classList.add("error-message");
                return false;
            } else if (!emailPattern.test(email)) {
                document.getElementById("error-message").innerHTML = "Please enter a valid email address";
                document.getElementById("error-message").classList.add("error-message");
                return false;
            }
            if (password == "") {
                document.getElementById("error-message2").innerHTML = "Password must be filled out";
                document.getElementById("error-message").classList.add("error-message");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <header>
        <div class="logo-container">
        <a href=<?php echo $frontpage?>> <img class="logo" src="../../Logo-and-text.png" alt="Logo"> </a>
        </div>
        <nav>
            <ul>
                <li><a href=<?php echo $frontpage?>>Front Page</a></li>
            </ul>
        </nav>
    </header>

    <h1>About Us</h1>
    <section class="donation-form">
        <div class="info-container">
            <h3>Blood Alert</h3>
            <p>
                Your blood can save lives. Blood donations are essential for emergency surgeries, transfusions, and 
                cancer treatment. However, many people forget to donate blood regularly leading to critical shortages 
                at blood banks. Blood Alert is a smart web application designed to encourage and assist Swedish citizens
                 in donating blood more frequently, helping ensure that blood banks have supplies available when needed. 
            </p>
            <br>
            <p>
                Blood Alert connects two key user groups: private blood donors and regional blood banks. When a certain 
                blood type is needed, the system sends messages to the donors with this blood type. Simultaneously, 
                the application helps blood banks with inventory management and to customize when alerts are to be sent 
                to eligible donors.
            </p>

            <h3>Our Purpose</h3>
            <p>
                Many in society are unaware of when their blood type is needed and that their blood is needed to save 
                lives. At the same time, blood banks often find it difficult to maintain access to blood and to reach 
                out to the right donors when levels of specific blood groups are low. By tracking donation schedules 
                and inventory levels, Blood Alert aims to simplify the donation process for donors and blood banks alike. 
                In doing so, the system seeks to be an asset to society by helping blood banks maintain a stable blood 
                supply. 
            </p>

        </div>
    </section>
</body>

<footer>
  <p>&copy; 2024 Blood Alert</p>
  <nav>
    <a href="about_us.php">About Us</a> |
    <a href="integrity_policy.php">Integrity Policy</a> |
    <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
  </nav>
</footer>
</html>
