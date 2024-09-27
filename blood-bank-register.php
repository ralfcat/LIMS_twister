

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
<h1>Blood Bank Register Page</h1>
    <!-- onsubmit="return validate_form();" -->
    <form onsubmit="return validate_form();" action=<?php echo $_SERVER['PHP_SELF']; ?> method="POST">
    <label for="email"> Email</label>
    <input type="text" id="email" name="email"> <span id="error_msg_em"></span><br>


        <!-- <label for="address"> Address</label>
        <select id="address" name="address">
    add the db stuff
        </select> <br> -->
        <label for="address"> Address</label>
        <select id="address" name="address">
            <?php while ($row = $reg_res->fetch_assoc()) {
                echo "<option value = " . $row['region'] . ">" . $row['region'] . "</option>";
            }

            ?>
        </select> <br>



        <label for="password"> Password</label>
        <input type="password" id="password" name="password"> <span id="error_msg_ps"></span><br>

        <label for="re-password"> Re-type Password</label>
        <input type="password" id="re-password" name="repassword"><span id="error_msg_rps"></span> <br>



        <label for="donate-date" id="dn"></label>
        <input type="hidden" id="donate-date" name="donateddate"> <br>

        <input type="submit" value="Register">
        <p id="demo"></p>





    </form>
    <p id="error_msg"></p>

</body>