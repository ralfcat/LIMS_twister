<?php
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
?>

<body>

    <h1>Donor Register Page</h1>

    <form action=<?php echo $_SERVER['PHP_SELF']; ?> onsubmit="return validate_form()" method="POST">
        <label for="fname"> First Name</label>
        <input type="text" id="fname" name = "fname"> <br>

        <label for="lname"> Last Name</label>
        <input type="text" id="lname" name = "lname"> <br>

        <label for="address"> Address</label>
        <select id="address" name = "address">
            <!-- Change this so that the regions comes from the database -->
            <option value="Stockholm">Stockholm</option>
            <option value="Jönköping">Jönköping</option>
            <option value="Kalmar">Kalmar</option>
        </select> <br>

        <label for="age"> Age</label>
        <input type="number" id="age" name = "age"> <br>

        <label for="sex"> Sex</label>
        <select id="sexes" onchange="check_preg()" name = "sexes">
            <option value="Male">Male</option>
            <option value="Female">Female</option>

        </select>

        <label for="preggo" id="pr"></label>
        <select hidden id="preg" name = "preg" value = "No">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select> <br>

        <label for="email"> Email</label>
        <input type="text" id="email" name = "email"> <br>

        <label for="password"> Password</label>
        <input type="password" id="password" name = "password"> <br>

        <label for="re-password"> Re-type Password</label>
        <input type="password" id="re-password" name = "repassword"> <br>

        <label for="btype"> Blood Type</label>
        <select id="btype" name = "btype">
            <option value="o-">O-</option>
            <option value="o+">O+</option>
            <option value="b-">B-</option>
            <option value="b+">B+</option>
            <option value="a-">A-</option>
            <option value="a+">A+</option>
            <option value="ab-">AB-</option>
            <option value="ab+">AB+</option>
            <option value="idk">Unsure</option>
        </select> <br>

        <label for="donated"> Have you donated blood before?</label>
        <select id="donateds" onchange="last_donated_date()" name = "donateds">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select>

        <label for="donate-date" id="dn"></label>
        <input type="hidden" id="donate-date" name = "donateddate"> <br>

        <input type="submit" value="Register">
        <p id="demo"></p>





    </form>
    <p id="error_msg"></p>

</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // use email catherine_miller_356@outlook.com
    echo '<script type="text/javascript">
    let err = document.getElementById("error_msg");
    document.getElementById("error_msg").innerHTML = "";
    </script>';

    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $address = $_POST["address"];
    $age = $_POST["age"];

    $sexes = $_POST["sexes"];
    $preg = $_POST["preg"];
    $email = $_POST["email"];
    $passowrd = $_POST["password"];
    echo 'the email entered is ' . $email;

    $repassword = $_POST["repassword"];
    $btype = $_POST["btype"];
    $donateds = $_POST["donateds"];
    $donateddate = $_POST["donateddate"];


    $sql_req = "SELECT COUNT(email) FROM Donor WHERE email = '" . $email. "'";
    $res = $link->query($sql_req);
    $row = $res->fetch_assoc();
    echo 'the value of row is  ' . $row['COUNT(email)'] ;

    if ($row > 0) {
        // echo '<p id=error_msg>The email you entered already exists</p>';
        echo '<script type="text/javascript">
        let err = document.getElementById("error_msg");
        document.getElementById("error_msg").innerHTML = "Email already exists";
        </script>';
    } 




}


?>

<script>
function validate_form() {
    var pass = document.getElementById("password").value;
    var repass = document.getElementById("re-password").value;
    var email = document.getElementById("email").value;

    if (!email.includes('@'))
    
    if (pass !==repass) {
        document.getElementById("error_msg").innerHTML = "Passwords do not match";
        return false;
    }else if (pass ===repass && pass ==='') {
        document.getElementById("error_msg").innerHTML = "Please enter a password";
        return false;
    }

    return false;

    // <label for="password"> Password</label>
    //     <input type="password" id="password" name = "password"> <br>

    //     <label for="re-password"> Re-type Password</label>
    //     <input type="password" id="re-password" name = "repassword"> <br>


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