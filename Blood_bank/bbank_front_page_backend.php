<?php

namespace FrontEnd;

require_once '../email_notif.php';
require_once '../unsubscribe.php';


use function EmailNotif\send_emails as send_emails;
use function Unsubscribe\remove_unsub;

error_reporting(E_ERROR | E_PARSE);

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "twister";
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

if (isset($_SESSION['loggedin'])) {
    $email = $_SESSION['email'];
}

function open_db()
{
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "twister";

    $link = mysqli_connect($servername, $username, $password, $dbname);

    // Check if connection is established
    if (mysqli_connect_error()) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        return $link;
    }
}

function write_js($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>" . $data . "</script>";
}

function write_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script> console.log( '$data');</script>";
}



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
        $update = update_levels($btype, $units);
        remove_unsub();
        $rid = get_rid();
        $bid = get_id();
        
        $curr_levels_array = get_stock($email);
        send_emails($curr_levels_array, $rid, $bid);
        if ($update == 0) {
        header('Location: bbank_front_page.php?msg=info_changed');}
        else {
            header('Location: bbank_front_page.php?msg=blood_stock_unchanged');
        }
      
    } else if ($to_do == "update_threshold") {
        
        write_console("you are trying to update thresholds");
        foreach ($_POST as $key => $value) {
            write_console("$key and the val is $value");
            if (str_starts_with($key, 'O') || str_starts_with($key, 'A') ||   str_starts_with($key, 'B') ||   str_starts_with($key, 'AB')) {
                if ($value < 0) {
                    header('Location: bbank_front_page.php?msg=blood_thresh_unchanged');
                    exit;
                } else {

                    remove_unsub();
                    update_thresholds($key, $value);
                }
            }
        }
        $rid = get_rid();
        $bid = get_id();
        $curr_levels_array = get_stock($email);
        send_emails($curr_levels_array, $rid, $bid);
        header('Location: bbank_front_page.php?msg=thresholds_changed');
    } else if ($to_do == "update_bb_info") {
        write_console("you are trying to update your blood bank info");
        $new_name = $_POST['new-name'];
        $new_pass = $_POST['password'];
        $new_name = (string) $new_name;
        $new_email = $_POST['new-email'];
        $new_region = $_POST['regions'];
        write_console("the new name is $new_name");
        update_account_info($new_name, $new_email, $new_region, $new_pass);
    }
}

class BloodStock
{
    public $blood_type;
    public $current_stock;
    public $thres_level;

    public function __construct($blood_type, $current_stock, $thres_level)
    {
        $this->blood_type = $blood_type;
        $this->current_stock = $current_stock;
        $this->thres_level = $thres_level;
    }
}
// -1 is returned as an error 
function get_threshold(array $current_levels, $target_blood_type)
{
    foreach ($current_levels as $level) {
        if ($level->blood_type == $target_blood_type) {
            return "$level->thres_level";
        }
    }
    return '-1';
}

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}




function get_stock($email)
{
    global $link;
    $bs_req = "SELECT Blood_Stock.* FROM Blood_Bank LEFT JOIN Blood_Stock ON Blood_Stock.blood_bank_id = Blood_Bank.blood_bank_id WHERE Blood_Bank.email = '$email'";

    $res = $link->query($bs_req);
    $blood_levels = array();
    while ($row = $res->fetch_assoc()) {
        $blood_level = new BloodStock($row["blood_type"], $row["stock_level"], $row["threshold_level"]);
        $blood_levels[] = $blood_level;
    }
    return $blood_levels;
}


// function get_stocks()
// {
//     global $link;
//     global $email;
//     $bs_req = "SELECT Blood_Stock.* FROM Blood_Bank LEFT JOIN Blood_Stock ON Blood_Stock.blood_bank_id = Blood_Bank.blood_bank_id WHERE Blood_Bank.email = '$email'";
//     $res = $link->query($bs_req);
//     $levels = array();
//     while ($row = $res->fetch_assoc()) {
//         $levels[] = $row;
//     }
//     return $levels;
// }



function get_id()
{
    global $email;
    global $link;
    $email_req = "SELECT blood_bank_id from Blood_Bank WHERE email = '$email'";
    $res = $link->query($email_req);
    $row = $res->fetch_assoc();
    return $row["blood_bank_id"];
}

function get_user_id($user_mail)
{
    global $link;
    $email_req = "SELECT donor_id from Donor WHERE email = '$user_mail'";
    $res = $link->query($email_req);
    $row = $res->fetch_assoc();
    echo '<h1>the value of id is' . $row["donor_id"] . '</h1><br>';
    return (int) $row["donor_id"];
}

function get_rid()
{
    global $email;
    global $link;
    $email_req = "SELECT region_id from Blood_Bank WHERE email = '$email'";
    $res = $link->query($email_req);
    $row = $res->fetch_assoc();
    return $row["region_id"];
}

function get_curr($btype, $id)
{
    global $link;
    $curr_req = "SELECT stock_level from Blood_Stock WHERE blood_type = '$btype' AND blood_bank_id = $id";
    $res = $link->query($curr_req);
    $row = $res->fetch_assoc();
    return $row["stock_level"];
}

function update_curr($btype, $new_level, $id)
{
    global $link;
    $update_req = "UPDATE Blood_Stock SET stock_level = ? WHERE blood_bank_id = ? AND blood_type = ?";
    $stmt = $link->prepare($update_req);
    $stmt->bind_param("iis", $new_level, $id, $btype);
    $stmt->execute();

   
 
}

function update_thresholds($btype, $threshold)
{
    global $link;
    global $email;
    // update the threshold
    // UPDATE Blood_Stock SET threshold_level = 5 WHERE blood_type = 'A+' AND blood_bank_id IN (SELECT blood_bank_id FROM Blood_Bank WHERE region_id = 1);

    // show the threshold
    // SELECT blood_type, threshold_level FROM Blood_Stock WHERE blood_bank_id IN( SELECT blood_bank_id FROM Blood_Bank WHERE region_id = 1) AND blood_type = 'A+';

    write_console("the bloodtype is $btype");
    $rid = get_rid();
    $update_req = "UPDATE Blood_Stock SET threshold_level = ? WHERE blood_type = ? AND blood_bank_id IN (SELECT blood_bank_id FROM Blood_Bank WHERE region_id = ?)";
    $stmt = $link->prepare($update_req);
    $stmt->bind_param("isi", $threshold,  $btype, $rid);
    $stmt->execute();


    echo "<script>console.log( 'the threshold levels was successfully updated');</script>";
}

function get_region_id($new_region)
{
    global $link;

    $sql_req = "SELECT rid FROM Region WHERE region = '$new_region'";
    $res = $link->query($sql_req);
    $row = $res->fetch_assoc();
    return $row["rid"];
}

function get_regional_levels()
{

    // SELECT * FROM Blood_Stock WHERE blood_bank_id = ANY (SELECT blood_bank_id FROM Blood_Bank WHERE region_id = ANY (SELECT region_id FROM Blood_Bank where email = 'bloodbank_2244@gmail.com'));

    $link = open_db();
    global $email;
    $sql_req = "SELECT blood_type, SUM(stock_level), MAX(threshold_level) FROM Blood_Stock WHERE blood_bank_id = ANY (SELECT blood_bank_id FROM Blood_Bank WHERE region_id = ANY (SELECT region_id FROM Blood_Bank where email = '$email')) GROUP BY blood_type";
    $res = $link->query($sql_req);
    $levels = array();
    while ($row = $res->fetch_assoc()) {
        $levels[] = $row;
    }
    close_db($link);
    return $levels;
}

function update_account_info($new_name, $new_email, $new_region, $new_password)
{
    global $email;
    global $success_message;
    write_js("console.log('I am in the update_account_info account info section');");
  
    $link = open_db();
    $rid = (int) get_region_id($new_region);
    if ($new_password == "") {
        $update_req = "UPDATE Blood_Bank SET name = ?, email = ? , region_id = ? WHERE email = ?";
        $stmt = $link->prepare($update_req);
        $stmt->bind_param("ssss", $new_name, $new_email, $rid, $email);

        if($stmt->execute()) {
            header('Location: bbank_info.php?msg=info_changed');

        } else {
            header('Location: bbank_info.php?msg=info_unchanged');
            
        }

    } else {
        $pass_salt = $new_password . $new_email;
        $hashed_password = hash('md5', $pass_salt);
        $update_req = "UPDATE Blood_Bank SET name = ?, email = ? , region_id = ?, password = ? WHERE email = ?";
        $stmt = $link->prepare($update_req);
        $stmt->bind_param("sssss", $new_name, $new_email, $rid,$hashed_password, $email);

        if($stmt->execute()) {
            header('Location: bbank_info.php?msg=info_changed');

        } else {
            header('Location: bbank_info.php?msg=info_unchanged');
            
        }
    }
    


    
}

function update_levels($btype, $units)
{
    $bb_id = get_id();
    $curr_level = get_curr($btype, $bb_id);
    echo "<script>console.log( 'the blood bank id is $bb_id and the curr level is $curr_level');</script>";
    $new_level = (int) $curr_level + (int) $units;
    if ($new_level < 0) {
        return -1;
        // header('Location: bbank_front_page.php?msg=blood_info_unchanged');
    } else {
        update_curr($btype, $new_level, $bb_id);
        return 0;

    }
}

function get_account_info()
{
    global $email;
    global $link;
    write_js("console.log('I am in the get account info section');");
    $sql_req = "SELECT * FROM Blood_Bank WHERE email = '$email'";
    $res = $link->query($sql_req);
    $row = $res->fetch_assoc();
    // foreach($row as $key => $value) {
    //     echo "<p>The key os $key and the value is $value</p>";
    // }
    return $row;
}

function curr_region()
{
    global $link;
    global $email;
    $sql_req = "SELECT region FROM Region INNER JOIN Blood_Bank ON Region.rid = Blood_Bank.region_id WHERE Blood_Bank.email = '$email'";
    $res = $link->query($sql_req);
    $row = $res->fetch_assoc();
    return $row['region'];
}


function get_regions()
{
    global $link;
    $sql_req = "SELECT region FROM Region";
    $res = $link->query($sql_req);
    $regions = array();
    while ($row = $res->fetch_assoc()) {
        $regions[] = $row['region'];
    }
    return $regions;
}
function close_db($link)
{
    
    $link->close();
}
