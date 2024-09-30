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
    $mail->Subject = 'Activate your BloodAlert blood bank account';
    $mail->Body = 'Click <a href="http://localhost:8888/Blood_bank/Bb_reg/activate-bb-account.php?token='.$activation_token.'"> to activate your blood bank account';

    $mail->AltBody = 'Click <a href="http://localhost:8888/Blood_bank/Bb_reg/activate-bb-account.php?token='.$activation_token.'"> to activate your blood bank account';


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
    <h1>Blood Bank Register Page</h1>
    <!-- onsubmit="return validate_form();" -->
    <!-- action=php echo $_SERVER['PHP_SELF'];  add the php tags -->
    <form method="POST" onsubmit="return validate_form();" action=<?php echo $_SERVER['PHP_SELF'];?> >
    <!-- <form method="POST" action=<?php echo $_SERVER['PHP_SELF'];?> > -->

        <label for> Blood Bank Name</label> <input type="text" id="name" name="name"> <span id="error_msg_n"></span>
        <br>

        <label> Email</label> <input type="text" id="email" name="email"> <span id="error_msg_em"></span><br>

        <label> Address</label>
        <select id="address" name="address">
            <?php while ($row = $reg_res->fetch_assoc()) {
                echo "<option value = " . $row['region'] . ">" . $row['region'] . "</option>";
            }

            ?>
        </select> <br>



        <label> Password</label>
        <input type="password" id="password" name="password"> <span id="error_msg_ps"></span><br>

        <label> Re-type Password</label>
        <input type="password" id="re-password" name="repassword"><span id="error_msg_rps"></span> <br>



        <label for="donate-date" id="dn"></label>
        <input type="hidden" id="donate-date" name="donateddate"> <br>

        <input type="submit" value="Register">
        <p id="demo"></p>





    </form>
    <p id="error_msg"></p>

</body>
<script>
    function validate_form() {
        let symbols = "!@#$%^&*()_+";
        symbols = [...symbols];
        console.log("trying to validate");

        class ErrId {
            constructor(val, id_name) {
                this.val = val;
                this.id_name = id_name;
            }
        }
        let name = new ErrId(document.getElementById("name").value, "error_msg_n");
        let pass = new ErrId(document.getElementById("password").value, "error_msg_ps");
        let repass = new ErrId(document.getElementById("re-password").value, "error_msg_rps");
        let email = new ErrId(document.getElementById("email").value, "error_msg_em");
        the_ids = new Array(name, email, pass, repass);




        for (id of the_ids) {
            document.getElementById(id.id_name).innerHTML = "";
        }
        document.getElementById("error_msg").innerHTML = "";

        for (id of the_ids) {
            if (id.val === "") {
                document.getElementById(id.id_name).innerHTML = "Please fill in the field";
                return false;
            }

        }
        if (!email.val.includes('@')) {
            document.getElementById("error_msg").innerHTML = "Please enter a valid email";
            return false;
        }
        if (pass.val !== repass.val) {
            document.getElementById("error_msg").innerHTML = "Passwords do not match";
            return false;
        }

        if (pass.val.length < 6 || !symbols.some(s => pass.val.includes(s))) {
            document.getElementById("error_msg").innerHTML =
                "Your password does not fulfil the password requirements:<br><ul><li>The password is too short (min. 6 characters) </li> <li>The password does not contain a symbol</li></ul>";
            return false;
        }


    }
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bbname = $_POST["name"];
    $email = $_POST["email"];
    $region = $_POST["address"];
    $password = $_POST["password"];
    $hashed_password = hash('md5', $password);


    $activation_token = bin2hex(random_bytes(16));
    $activation_token_hash = hash("md5", $activation_token);

    $sql_req = "SELECT COUNT(email) FROM Blood_Bank WHERE email = '" . $email . "'";
    $res = $link->query($sql_req);
    $row = $res->fetch_assoc();
    $count = $row['COUNT(email)'];

    if ($count > 0) {
        echo '<p id=error_msg>The email you entered already exists</p>';
    } else {
        $insert_sql = "INSERT INTO Blood_Bank (name, address, email, password, account_activation_hash) VALUES (?, ?, ?, ?, ?)";
        $stmt = $link->prepare($insert_sql);
        $stmt->bind_param("sssss", $bbanme, $region, $email, $hashed_password, $activation_token_hash);
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