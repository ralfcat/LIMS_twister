<?php 


function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "twister";

$link = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection is established
if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql_req = "SELECT movies.mid, movies.mname, movies.myear, movies.mgenre, movies.mrating, genres.mgenre FROM Blood_Stock WHERE Blood_Stock.blood_bank_id = " . $mid;
$res = $link->query($sql_req);
$row = $res->fetch_assoc();
$genre_req = "SELECT gid, mgenre FROM genres";
$genre_res = $link->query($genre_req);


$mname = $_POST['O+'];

echo "<h1>". $mname."</h1>";
debug_to_console($mname);