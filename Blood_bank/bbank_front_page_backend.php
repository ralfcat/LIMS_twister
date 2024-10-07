<?php 

namespace FrontEnd;

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "twister";
session_start();

$email = $_SESSION['email'];

$link = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection is established
if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $to_do = $_POST["to_do"];
    if ($to_do == "update_blood") {
        $btype = $_POST['btypes'];
        $units = $_POST['units'];
        update_levels($btype, $units);
        echo "<script>console.log( 'in the post request $btype and $units ');</script>";
    }
}

class BloodStock {
    public $blood_type;
    public $current_stock;
    public $thres_level;

    public function __construct($blood_type, $current_stock, $thres_level ) {
        $this ->blood_type = $blood_type;
        $this -> current_stock = $current_stock;
        $this -> thres_level = $thres_level; 
    }
}
// -1 is returned as an error 
function get_threshold(array $current_levels, $target_blood_type) {
    foreach ( $current_levels as $level ) {
        if ($level->blood_type == $target_blood_type) {
            return "$level->thres_level"; 
        }
    }
    return '-1';

    
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}



// $sql_req = "SELECT movies.mid, movies.mname, movies.myear, movies.mgenre, movies.mrating, genres.mgenre FROM Blood_Stock WHERE Blood_Stock.blood_bank_id = " . $mid;
// $res = $link->query($sql_req);
// $row = $res->fetch_assoc();
// $genre_req = "SELECT gid, mgenre FROM genres";
// $genre_res = $link->query($genre_req);


// $mname = $_POST['O+'];

// echo "<h1>". $mname."</h1>";
// debug_to_console($mname);

function get_stock($email) {
    global $link;
    $bs_req = "SELECT Blood_Stock.* FROM Blood_Bank LEFT JOIN Blood_Stock ON Blood_Stock.blood_bank_id = Blood_Bank.blood_bank_id WHERE Blood_Bank.email = '$email'";
    
    $res = $link ->query($bs_req);
    $blood_levels = array();
    while ($row = $res->fetch_assoc()) {
        $blood_level = new BloodStock($row["blood_type"], $row["stock_level"], $row["threshold_level"]);
        $blood_levels[] = $blood_level;


        // $x = implode(" ",$row);
        // $y = var_dump($row);
        // echo "the email is $y <br>";
    }
    // foreach ($blood_levels as $b) {
    //     $y = var_dump($b);
    //     echo " $y  in the for each <br>";


    // }
    return $blood_levels;
    
}



// if (isset($_POST['action'])) {
//     switch ($_POST['action']) {
//         case 'update':
//             update_levels();
//             break;

//     }
// }

function get_id(){
    global $email;
    global $link;
    $email_req = "SELECT blood_bank_id from Blood_Bank WHERE email = '$email'";
    $res = $link->query($email_req);
    $row = $res->fetch_assoc();
    return $row["blood_bank_id"];
}

function get_curr($btype, $id)  {
    global $link;
    $curr_req = "SELECT stock_level from Blood_Stock WHERE blood_type = '$btype' AND blood_bank_id = $id";
    $res = $link->query($curr_req);
    $row = $res->fetch_assoc();
    return $row["stock_level"];

}

function update_curr($btype, $new_level, $id) {
    global $link;
    $update_req = "UPDATE Blood_Stock SET stock_level = ? WHERE blood_bank_id = ? AND blood_type = ?";
    $stmt = $link->prepare($update_req);
    $stmt->bind_param("iis", $new_level, $id, $btype);
    $result = $stmt->execute();
    echo "<script>console.log( 'the value was successfully updated');</script>";



}

function update_levels($btype, $units) {
    $bb_id = get_id();
    $curr_level = get_curr($btype, $bb_id);
    echo "<script>console.log( 'the blood bank id is $bb_id and the curr level is $curr_level');</script>";
    $new_level = (int) $curr_level + (int) $units;
    update_curr($btype, $new_level, $bb_id);
    header('Location: bbank_front_page.php');

}