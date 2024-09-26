<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "twister";

// Create connection
$link = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection is established
if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}
$error_email = "";
$error_password = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT email, password, account_activation_hash from Donor WHERE email = ? AND (account_activation_hash = '' OR account_activation_hash IS NULL)";
    //to prevent sql injections
    $stmt = $link->prepare($sql);
    $stmt -> bind_param('s', $email);
    $stmt -> execute();
    $result = $stmt -> get_result(); 

    if ($result->num_rows > 0) {
        $row = $result -> fetch_assoc();
        $hashed_password = $row['password'];
        //if (password_verify($password, $hashed_password)) {
        if (md5($password) == $hashed_password) {
            //password matches, the user is logged in and redirected to their "my donation page"
            $_SESSION['email'] = $row['email'];
            header("Location: my_donations.php");
            exit(); 
        } else {
            //password not matching
            $error_password = "Invalid password.";
        }
    } else {
        //no user found with email
        $error_email = "No user found with that email.";
    }

    // Close statement and connection
    $stmt->close();
    $link->close();
    }
        
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blood Donor Log in</title>
    <link rel="stylesheet" href="../styles.css" />
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
    <div class="box">
        <h1>Donor Log in</h1>
        <form name ="loginform" action="donor_log_in.php" method="POST" onsubmit="return validateForm()">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Type email" />
            </div>
            <div id="error-message" style="color:red;">
                <?php echo $error_email; ?>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Type password" />
            </div>
            <div id="error-message2" style="color:red;">
                <?php echo $error_password; ?>
            </div>
            <button type="submit">Log in</button>
        </form>
        <!-- New user link on the same line -->
        <div class="new-user">
            <p>New user? <a href="../create_account.php">Create an account here</a></p>
            
        </div>
    </div>
</body>
</html>


