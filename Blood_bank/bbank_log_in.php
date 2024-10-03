<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../BloodAlert_logo.png">
    <title>Blood Bank Log in</title>
    <link rel="stylesheet" href="../../stylesheet/styles.css">
    <link rel="stylesheet" href="../../stylesheet/reset.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&display=swap">
    <script>
        function validateForm() {
            let email = document.forms["loginform"]["email"].value;
            let password = document.forms["loginform"]["password"].value;
            
            let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            
            document.getElementById("error-message").innerHTML = "";
            document.getElementById("error-message2").innerHTML = "";
            if (email == "") {
                document.getElementById("error-message").innerHTML = "Email must be filled out";
                return false;
            } else if (!emailPattern.test(email)) {
                document.getElementById("error-message").innerHTML = "Please enter a valid email address";
                return false;
            }
            if (password == "") {
                document.getElementById("error-message2").innerHTML = "Password must be filled out";
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
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

        <!-- New user link on the same line -->
        <div class="new-user">
            <p>New user? <a href="create_account.php">Create an account here</a></p>
        </div>
    </div>
</body>
