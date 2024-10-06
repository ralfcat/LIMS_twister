<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../BloodAlert_logo.png">
    <title>Blood Bank Login</title>
    <link rel="stylesheet" href="../../stylesheet/reset.css">
    <link rel="stylesheet" href="../../stylesheet/styles2.css">
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
                document.getElementById("error-message").classList.add("error-message-style");
                return false;
            }
            if (password == "") {
                document.getElementById("error-message2").innerHTML = "Password must be filled out";
                document.getElementById("error-message").classList.add("error-message-style");
                return false;
            }
            return true;
        }
    </script>
</head>
<header>
        <div class="logo-container">
            <img class="logo" src="../../Logo-and-text.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="../Donor/Donor_login/donor_log_in.php">Donor Log in</a></li>
            </ul>
        </nav>
    </header>
    <div class=login-container> 
        <div class=login-form>
            <h2>Blood Bank Log in</h2>
            <form action="my_donations.php" method="GET">
                <div class="input-group">
                    <input type="text" id="email" name="email" placeholder="Email" />
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password" />
                </div>
                <button class="login_button">Log in</button>
            </form>
            <div class="new-user">
                <p>Want to register? <a href="/blood-bank-register.php">Contact us</a></p>
            </div>
        </div>
    </div>
</body>
</html>

