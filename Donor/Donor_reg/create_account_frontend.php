<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "twister";



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';
require '../../config.php';

function sendMail($email, $activation_token)
{
    $mail = new PHPMailer(true);
    $mail->isHTML(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = MAILHOST;
    $mail->Username = USERNAME;
    $mail->Password = PASSWORD;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom(SEND_FROM, SEND_FROM_NAME);
    $mail->addAddress($email);
    $mail->addReplyTo(REPLY_TO, REPLY_TO_NAME);
    $mail->isHTML(false);
    $mail->Subject = 'Activate your account';
    $mail->Body = 'Click <a href="http://localhost:8888/Donor/Donor_reg/activate-account.php?token=' . $activation_token . '"> to activate your account';

    $mail->AltBody = 'Click <a href="http://localhost:8888/Donor/Donor_reg/activate-account.php?token=' . $activation_token . '"> to activate your account';

    if (!$mail->send()) {
        return -1;
    } else {

        return 0;
    }
}

// Create connection
$link = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection is established
if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}

$reg_req = "SELECT region FROM Region";
$reg_res = $link->query($reg_req);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/BloodAlert_logo.png">
    <title>Fill out account</title>
    <link rel="stylesheet" href="/stylesheet/reset.css">
    <link rel="stylesheet" href="/stylesheet/styles2.css">

</head>

<body>
    <header>
        <div class="logo-container">
           <a href = "../../index.php"> <img class="logo" src="../../Logo-and-text.png" alt="Logo"></a>
        </div>
        <nav>
            <ul>
                <li><a href="Donor/Donor_login/donor_log_in.php">Donor Login</a></li>
                <li><a href="Blood_bank/bbank_log_in.php">Blood Bank Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- SCRIPTS FOR SHOWING/HIDING PASSWORD-->
        <script>
            function togglePassword() {
                var oldPasswordField = document.getElementById('password');
                var newPasswordField = document.getElementById('repeat_password');

                if (oldPasswordField.type === "password" || newPasswordField.type === "password") {
                    oldPasswordField.type = "text";
                    newPasswordField.type = "text";
                    button.textContent = "Hide passwords";
                } else {
                    oldPasswordField.type = "password";
                    newPasswordField.type = "password";
                    button.textContent = "Show passwords";
                }
            }
        </script>
        <!-- SCRIPTS FOR SHOWING/HIDING PASSWORD-->
        <h1>Create Account</h1>
        <p id='successMessage'></p>
        <section class="donation-form" id="donform">
            <!-- onsubmit="return validate_form();" -->
            <form method="POST" action=<?php echo $_SERVER['PHP_SELF']; ?> onsubmit="return validate_form();">

                <div class="form-container">

                    <!-- Left Column -->
                    <div class="form-column">
                        <p id="error_msg"></p>
                        <h3>Name:</h3> <span id="error_msg_n"></span>
                        <input type="text" id="name" name="name" placeholder="Enter name">

                        <h3>Age:</h3><input type="number" id="age" name="age"><span id="error_msg_ag"></span> <br>

                        <h3>Email:</h3> <span id="error_msg_em"></span><br>
                        <input type="text" id="email" name="email" placeholder="Enter email">
                        <h3>Password:</h3><span id="error_msg_ps"></span>
                        <input type="password" id="password" name="password" placeholder="Enter password">

                        <h3>Re-enter password:</h3><span id="error_msg_rps"></span>
                        <input type="password" id="repeat_password" name="repeat_password" placeholder="Repeat password">

                        <label class="terms-condition"> 
                            <input type="checkbox" name="confirm" required>
                            <p> I have read and agreed to the <a href="terms_cond_donor.html" target="blank" rel="noreferrer noopener">Terms and Conditions </a> </p>
                        </label>
                        <button class="profile-changes-button" type="submit">Create Account</button>
                        <br>


                    </div>

                    <!-- Right Column -->
                    <div class="form-column">
                        <h3>Blood type:</h3> <span id="error_msg_bt"></span>
                        <select name="btype" id="sbt">
                            <option value="select" selected>Select your blood type</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>

                        <h3>Sex:</h3><span id="error_msg_sx"></span>
                        <select id="sexes" onchange="check_preg()" name="sexes">
                            <option value="select" selected>Select your sex</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>

                        <h3><label for="preggo" id="pr"></label></h3>
                        <select hidden id="preg" name="preg" value="No">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select> <br>

                        <h3>Region:</h3><span id="error_msg_rg"></span>
                        <select name="region" id="reg">
                            <option value="select" selected>Select your region</option>
                            <?php while ($row = $reg_res->fetch_assoc()) {
                                echo "<option value = " . $row['region'] . ">" . $row['region'] . "</option>";
                            }

                            ?>
                        </select>

                        <h3><label for="donated"> Have you donated blood before?</label></h3>
                        <select id="donateds" onchange="last_donated_date()" name="donateds">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                            <option value="I don't remember">I don't remember</option>
                        </select>

                        <h3><label for="donate-date" id="dn"></label></h3>
                        <input type="hidden" id="donate-date" name="donateddate"> <br>
                    </div>
                </div>
            </form>
        </section>
    </main>
</body>

<footer>
    <p>&copy; 2024 Blood Alert</p>
    <nav>
        <a href="../../about_us.html">About Us</a> |
        <a href="../../integrity_policy.html">Integrity Policy</a> |
        <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
    </nav>
</footer>

<script>
    function fill_form(fname, lname, pass) {
        console.log("this function is executed");
        var pass_field = document.getElementById("password");
        var name_field = document.getElementById("name");
        var name = fname.concat(' ', lname);


        pass_field.value = pass;
        name_field.value = name;




    }

    function validate_form() {
        console.log("trying to validate form ");
        let ids = ["error_msg_n", "error_msg_ag", "error_msg_em", "error_msg_ps", "error_msg_rps", "error_msg_bt", "error_msg_sx", "error_msg_rg", "error_msg"];
        let symbols = "!@#$%^&*()_+";
        symbols = [...symbols];
        for (id of ids) {
            document.getElementById(id).innerHTML = "";

        }
        const checked_terms = document.getElementById("chckbx").checked;
        var pass = document.getElementById("password").value;
        var repass = document.getElementById("repeat_password").value;
        var email = document.getElementById("email").value;
        var age = document.getElementById('age').value;
        age = Number(age);
        let name = document.getElementById("name").value;
        var btype = document.getElementById("sbt").value;
        var sex = document.getElementById("sexes").value;
        var reg = document.getElementById("reg").value;



        if (name == "") {

            document.getElementById("error_msg_n").innerHTML = "Please fill in the field";
            return false;
        }

        if (age == "") {
            document.getElementById("error_msg_ag").innerHTML = "Please fill in the field";
            return false;
        }
        if (email === "") {
            document.getElementById("error_msg_em").innerHTML = "Please fill in the field";
            return false;
        }
        if (pass === "") {
            document.getElementById("error_msg_ps").innerHTML = "Please fill in the field";
            return false;
        }
        if (repass === "") {
            document.getElementById("error_msg_rps").innerHTML = "Please fill in the field";
            return false;
        }
        if (btype == "select") {
            document.getElementById("error_msg_bt").innerHTML = "Please fill in the field";
            return false;

        }
        if (sex == "select") {
            document.getElementById("error_msg_sx").innerHTML = "Please fill in the field";
            return false;

        }
        if (reg == "select") {
            document.getElementById("error_msg_rg").innerHTML = "Please fill in the field";
            return false;

        }
        if (!email.includes('@')) {
            document.getElementById("error_msg").innerHTML = "Please enter a valid email";
            return false;
        }

        if (age < 18) {
            document.getElementById("error_msg").innerHTML = "You are too young to register";
            return false;
        }
        if (age > 60) {
            document.getElementById("error_msg").innerHTML = "You are too old to register";
            return false;
        }

        if (pass !== repass) {
            document.getElementById("error_msg").innerHTML = "Passwords do not match";
            return false;
        } else if (pass === repass && pass === '') {
            document.getElementById("error_msg").innerHTML = "Please enter a password";
            return false;
        }
        if (pass.length < 6 || !symbols.some(s => pass.includes(s))) {
            document.getElementById("error_msg").innerHTML = "Your password does not fulfil the password requirements:<br><ul><li>The password is too short</li> <li>The password does not contain a symbol</li></ul>";
            return false;
        }
        if (!checked_terms) {
            document.getElementById("error_msg").innerHTML = "Please read and agree to the terms and conditions";
            return false;

        }
        return true;


    }

    function last_donated_date() {
        var donated = document.getElementById("donateds").value;
        if (donated === "Yes") {

            document.getElementById("dn").innerHTML = 'When did you last donate?'
            document.getElementById("donate-date").type = 'date'
        } else {
            document.getElementById("dn").innerHTML = ''
            document.getElementById("donate-date").type = 'hidden'

        }
    }

    function check_preg() {
        let sel = document.getElementById('preg');
        let label = document.getElementById('pr');
        let hidden = sel.getAttribute("hidden");
        var sex = document.getElementById("sexes").value;
        if (sex === "Female") {
            sel.removeAttribute("hidden");
            label.innerHTML = 'Are you pregnant or breastfeeding?';

        } else {
            sel.setAttribute("hidden", "hidden");
            label.innerHTML = '';
        }
    }
</script>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["to_do"])) {
        if ($_POST["to_do"] == "create_new") {
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            $pass = $_POST["password"];
            echo "<script> fill_form('$fname', '$lname', '$pass') </script>";
        }
    } else {
        // use email catherine_miller_356@outlook.com for testing
        echo '<script> type="text/javascript">
    let err = document.getElementById("error_msg");
    document.getElementById("error_msg").innerHTML = "";
    </script>';


        $name = $_POST["name"];
        $address = $_POST["region"];
        $age = $_POST["age"];

        $sexes = $_POST["sexes"];
        $preg = $_POST["preg"];
        $email = $_POST["email"];
        $activation_token = bin2hex(random_bytes(16));
        $activation_token_hash = hash("md5", $activation_token);

        $password = $_POST["password"];
        $password_salt = $password . $email;

        $hashed_password = hash('md5', $password_salt);


        $btype = $_POST["btype"];
        $donateds = $_POST["donateds"];
        $donateddate = $_POST["donateddate"];
        $eli = false;
        $insert_sql = "";



        if ($donateds == "Yes") {
            $donated_date_format = date($donateddate);
            $donateddate = $donated_date_format;
            $today = getdate();
            $day = $today['mday'];
            $mon = $today['mon'];
            $year = $today['year'];
            $date_str = $year . "-" . $mon . "-" . $day;
            $todays_date = date_create($date_str);
            $six_mon_ago = date_sub($todays_date, date_interval_create_from_date_string('6 months'));
            $six_mon_ago = $six_mon_ago->format('Y-m-d');

            if (($donated_date_format >= $six_mon_ago) && ($donated_date_format <= $date_str)) {
                $eli = true;
            } else {
                $eli = false;
            }

            $insert_sql = "INSERT INTO Donor (name, age, sex, address, email, password, blood_type, last_donation_date, is_eligible, account_activation_hash) VALUES (?,?,?,?,?,?,?,?,?, ?)";
            $stmt = $link->prepare($insert_sql);
            $stmt->bind_param("sissssssss", $name, $age, $sexes, $address, $email, $hashed_password, $btype, $donateddate, $eli, $activation_token_hash);
        } else {
            $insert_sql = "INSERT INTO Donor (name, age, sex, address, email, password, blood_type, is_eligible, account_activation_hash) VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt = $link->prepare($insert_sql);
            $stmt->bind_param("sisssssis", $name, $age, $sexes, $address, $email, $hashed_password, $btype, $eli, $activation_token_hash);
        }





        $sql_req = "SELECT COUNT(email) FROM Donor WHERE email = '" . $email . "'";
        $res = $link->query($sql_req);
        $row = $res->fetch_assoc();
        $count = $row['COUNT(email)'];

        if ($count > 0) {
            echo '<p id=error_msg>The email you entered already exists</p>';
        } else {


            $insert_res = $stmt->execute();

            if ($insert_res) {
                $amail = sendMail($email, $activation_token);
                //  pass_field = document.getElementById("password");
                // echo "<script>var succ = document.getElementById('successMessage'); 
                // succ.innerHTML = ' Please check your email to activate your account ';
                // </script>";

                if ($amail == 0) {

                    echo "<script>
                const parentElement = document.getElementById('donform');
                const newChild = document.createElement('h3');
                newChild.innerHTML = ' Please check your email to activate your account ';
            parentElement.insertBefore(newChild, parentElement.firstChild);
                </script>";
                } else {

                    echo "<script>
                    const parentElement = document.getElementById('donform');
                    const newChild = document.createElement('h3');
                    newChild.innerHTML = 'An error occcured and your account could not be created. Please try again';
                parentElement.insertBefore(newChild, parentElement.firstChild);
                    </script>";
                }
            } else {
                echo "<script>
                const parentElement = document.getElementById('donform');
                const newChild = document.createElement('h3');
                newChild.innerHTML = ' Error: $stmt->error';
            parentElement.insertBefore(newChild, parentElement.firstChild);
                </script>";
            }
        }
    }
}


?>