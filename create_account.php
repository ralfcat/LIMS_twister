<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "twister";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;  
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'config.php';

function sendMail($email, $activation_token) {
    $mail = new PHPMailer(true);
    $mail->isHTML(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = MAILHOST;
    $mail->Username = USERNAME;
    $mail->Password = PASSWORD;
    $mail->SMTPSecure = 'tls'; 
    $mail->Port=587;
    $mail->setFrom(SEND_FROM,SEND_FROM_NAME);
    $mail->addAddress($email);
    $mail->addReplyTo(REPLY_TO, REPLY_TO_NAME);
    $mail->isHTML(false);
    $mail->Subject = 'Activate your account';
    $mail->Body = 'Click <a href="http://localhost:8888/activate-account.php?token='.$activation_token.'"> to activate your account';

    $mail->AltBody = 'Click <a href="http://localhost:8888/activate-account.php?token='.$activation_token.'"> to activate your account';

    // if (!$mail->send()) {
    //     echo 'EMAIL WAS NOT SENT';
    //     return 'EMAIL WAS NOT SENT';
    // } else {
    //     echo 'SUCCESS';
    //     return 'SUCCESS';
    // }

    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent Error:". $mail->ErrorInfo ."";}
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

<body>

    <h1>Donor Register Page</h1>
    <!-- onsubmit="return validate_form();" -->
    <form action=<?php echo $_SERVER['PHP_SELF']; ?> method="POST">
        <label for> First Name</label>
        <input type="text" id="fname" name="fname">
        <span id="error_msg_fn"></span>
        <br>

        <label for> Last Name</label>
        <input type="text" id="lname" name="lname"><span id="error_msg_ln"></span> <br>

        <label for="address"> Address</label>
        <select id="address" name="address">
            <?php while ($row = $reg_res->fetch_assoc()) {
                echo "<option value = " . $row['region'] . ">" . $row['region'] . "</option>";
            }

            ?>
        </select> <br>

        <label> Age</label>
        <input type="number" id="age" name="age"><span id="error_msg_ag"></span> <br>

        <label for="sex"> Sex</label>
        <select id="sexes" onchange="check_preg()" name="sexes">
            <option value="Male">Male</option>
            <option value="Female">Female</option>

        </select>

        <label for="preggo" id="pr"></label>
        <select hidden id="preg" name="preg" value="No">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select> <br>

        <label for="email"> Email</label>
        <input type="text" id="email" name="email"> <span id="error_msg_em"></span><br>

        <label for="password"> Password</label>
        <input type="password" id="password" name="password"> <span id="error_msg_ps"></span><br>

        <label for="re-password"> Re-type Password</label>
        <input type="password" id="re-password" name="repassword"><span id="error_msg_rps"></span> <br>

        <label for="btype"> Blood Type</label>
        <select id="btype" name="btype">
            <option value="O-">O-</option>
            <option value="O+">O+</option>
            <option value="B-">B-</option>
            <option value="b+">B+</option>
            <option value="A-">A-</option>
            <option value="A+">A+</option>
            <option value="AB-">AB-</option>
            <option value="AB+">AB+</option>
            <option value="Unsure">Unsure</option>
        </select> <br>

        <label for="donated"> Have you donated blood before?</label>
        <select id="donateds" onchange="last_donated_date()" name="donateds">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
            <option value="I don't remember">I don't remember</option>
        </select>

        <label for="donate-date" id="dn"></label>
        <input type="hidden" id="donate-date" name="donateddate"> <br>

        <input type="submit" value="Register">
        <p id="demo"></p>





    </form>
    <p id="error_msg"></p>

</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // use email catherine_miller_356@outlook.com for testing
    echo '<script type="text/javascript">
    let err = document.getElementById("error_msg");
    document.getElementById("error_msg").innerHTML = "";
    </script>';

    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $name = $fname . " " . $lname;
    $address = $_POST["address"];
    $age = $_POST["age"];

    $sexes = $_POST["sexes"];
    $preg = $_POST["preg"];
    $email = $_POST["email"];
    $activation_token = bin2hex(random_bytes(16));
    $activation_token_hash = hash("md5", $activation_token);

    $password = $_POST["password"];

    $hashed_password = hash('md5', $password);


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
        // echo '<script type="text/javascript">
        // let err = document.getElementById("error_msg");
        // document.getElementById("error_msg").innerHTML = "Email already exists";
        // </script>';
    } else {


        $insert_res = $stmt->execute();

        if ($insert_res) {
            $amail = sendMail($email, $activation_token);
            echo "<h2> Please check your email to activate your account </h2>";
        } else {
            echo "<h2> Error: " . $stmt->error . "</h2>";
        }
    }
}


?>

<script>
    function validate_form() {
        let ids = ["error_msg_fn", "error_msg_ln", "error_msg_ag", "error_msg_em", "error_msg_ps", "error_msg_rps", "error_msg"];
        let symbols = "!@#$%^&*()_+";
        symbols = [...symbols];
        for (id of ids) {
            document.getElementById(id).innerHTML = "";

        }
        var pass = document.getElementById("password").value;
        var repass = document.getElementById("re-password").value;
        var email = document.getElementById("email").value;
        var age = document.getElementById('age').value;
        age = Number(age);
        let fname = document.getElementById("fname").value;
        // alert(`the value of the first name is ${fname === ""}`);
        var lname = document.getElementById("lname").value;
        // mariam.alabi@outlook.com    



        if (fname == "") {

            document.getElementById("error_msg_fn").innerHTML = "Please fill in the field";
            return false;
        }
        if (lname === "") {

            document.getElementById("error_msg_ln").innerHTML = "Please fill in the field";
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
        return true;


    }

    function last_donated_date() {
        var donated = document.getElementById("donateds").value;
        if (donated === "No") {
            document.getElementById("dn").innerHTML = ''
            document.getElementById("donate-date").type = 'hidden'
        } else {
            document.getElementById("dn").innerHTML = 'When did you last donate?'
            document.getElementById("donate-date").type = 'date'
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