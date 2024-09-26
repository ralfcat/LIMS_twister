<?php 
$token = $_GET["token"];
$token_hash = hash("md5", $token);
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "twister";

$link = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection is established
if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = 'SELECT * FROM Donor WHERE account_activation_hash = "' . $token_hash . '"';

$req = $link->query($sql);
$user = $req->fetch_assoc();

if ($user === null) {
    die('token not found');
}

$change_sql = "UPDATE Donor SET account_activation_hash = NULL WHERE donor_id = ? " ;
$stmt = $link->prepare($change_sql);
$stmt->bind_param("i", $user["donor_id"]);
$stmt->execute();   

?>

<h1>Account Activated</h1>
<p>Account activated successfully. You can now <a href="donor_log_in.php">log in</a>.</p>
