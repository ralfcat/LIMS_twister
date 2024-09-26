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

$reg_req = "SELECT region FROM Region";
$reg_res = $link->query($reg_req);
?>

<body>

    <h1>Donor Register Page</h1>
    <!-- onsubmit="return validate_form()" -->
    <form action=<?php echo $_SERVER['PHP_SELF']; ?> method="POST">
        <label for="fname"> First Name</label>
        <input type="text" id="fname" name = "fname"> <br>

        <label for="lname"> Last Name</label>
        <input type="text" id="lname" name = "lname"> <br>

        <label for="address"> Address</label>
        <select id="address" name = "address">
             <?php while ($row = $reg_res-> fetch_assoc()) {
                echo "<option value = " . $row['region'] . ">" . $row['region'] . "</option>";
             }
             
             ?>
        </select> <br>

        <label> Age</label>
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
            <option value="I don't remember">I don't remember</option>
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
    // use email catherine_miller_356@outlook.com for testing
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
    echo '<p>the email entered is ' . $email . '</p>';

    $repassword = $_POST["repassword"];
    $btype = $_POST["btype"];
    $donateds = $_POST["donateds"];
    $donateddate = $_POST["donateddate"];
    $is_eli = false;

    

    if ($donateds == "Yes") {
        $donated_date_format = date($donateddate);
        $today = getdate();
        $day = $today['mday'];
        $mon = $today['mon'];
        $year = $today['year'];
        $date_str = $year . "-" . $mon . "-" . $day;
        $todays_date = date_create($date_str);
        $six_mon_ago = date_sub($todays_date, date_interval_create_from_date_string('6 months'));
        $six_mon_ago =$six_mon_ago->format('Y-m-d');

        if (($donated_date_format >= $six_mon_ago) && ($donated_date_format <= $date_str)) {
            echo '<p> You donated within 6 months </p>';
            $is_eli = true;
        } else {
            $is_eli = false;
            echo '<p> It has been so long since you donated </p>';
        }


    }



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
    var age = document.getElementById('age').value;
    age = Number(age);
    // mariam.alabi@outlook.com    

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