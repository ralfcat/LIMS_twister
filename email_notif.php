<?php 

/*

1. Connect to database
2. Get a list of users in a particular region (test with Stockholm)
*/

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "twister";

$user_query = "SELECT * FROM Donor WHERE address = 'Stockholm'";

echo "Hello <br>";
$link = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection is established
if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_request = $link ->query($user_query);



while ($row = $user_request->fetch_assoc()) {
    echo $row['email'] . "<br>"; 
}


mysqli_close($link);



