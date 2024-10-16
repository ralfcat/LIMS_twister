<?php 


namespace EmailNotif;
require_once 'Blood_bank/bbank_front_page_backend.php';

use FrontEnd\BloodStock as BloodStock;
use function FrontEnd\get_user_id as get_user_id;
use function FrontEnd\get_region_id as get_region_id;
// get_region_id($new_region)
/*

1. Connect to database
2. Get a list of users in a particular region (test with Stockholm)
*/
class Recipient
{
    public $userid;
    public $date;
    public $address;
    public $name;

    public function __construct($userid, $date, $address, $name)
    {
        $this->userid -> $userid;
        $this->date = $date;
        $this->address = $address;
        $this->name = $name;
    }
}

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "twister";

// Select the donors where the address is Stockholm (change this for the region)
$user_query = "SELECT * FROM Donor WHERE address = 'Stockholm'";

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


function check_level_against_threshold(array $blood_levels, $rid) {
        foreach($blood_levels as $level) {
        $curr_stock = $level->current_stock;
        $thresh = $level ->thres_level;
        $type = $level ->blood_type;

        if ($curr_stock < $thresh) {
            $mail_list = get_mail_list($type, $rid);
            // send_email();
            populate_notif_db($mail_list);

        }

    }

}

// Get the list of people that will be sent an email as an array, and the number of people that will be sent an email
function get_mail_list($btype, $rid) {
    global $link;
    $sql_que = "SELECT name, email, address, is_eligible, blood_type from Donor 
    where address IN (SELECT region from Region WHERE rid = $rid) AND is_eligible = 1 AND blood_type = '$btype'";
    $sql_request = $link ->query($sql_que);


    $mail_list = array();
    while ($row = $sql_request->fetch_assoc()) {
        $user_id = get_user_id($row['email']);
        $reci = new Recipient($user_id, date('Y-m-d H:i:s'), $row['address'], $row['name']);
        $mail_list[] = $reci;
    }
    return $mail_list;

}

function populate_notif_db($mail_list) {
    global $link;

    // create the message for the log
    foreach($mail_list as $mailer) {
        $user_id = $mailer -> userid;
        $date = $mailer-> date;
        $rid = get_region_id($mailer -> address);
        

        $sql_req = "INSERT INTO Notification (notification_date, rid, donor_id) VALUES (?,?,?)";
        $stmt = $link->prepare($sql_req);
   
        $stmt->bind_param("sii", $date, $rid, $user_id);
        $stmt->execute();
}

}

