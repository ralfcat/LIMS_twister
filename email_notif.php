<?php 


namespace EmailNotif;
require_once 'Blood_bank/bbank_front_page_backend.php';

use FrontEnd\BloodStock as BloodStock;
/*

1. Connect to database
2. Get a list of users in a particular region (test with Stockholm)
*/

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "twister";

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
            get_mail_list($type, $rid);
            // send_email();
            // populate_notif_db();

        }

    }

}

// Get the list of people that will be sent an email as an array, and the number of people that will be sent an email
function get_mail_list($btype, $rid) {
    $sql_req = "SELECT name, email, address, is_eligible, blood_type from Donor where address IN (SELECT region from Region WHERE rid = $rid) AND is_eligible = 1 AND blood_type = '$btype'";

}

function populate_notif_db($rid) {
    // get the current date and time
    $current_date = date('Y-m-d H:i:s');

    // create the message for the log

    $sql_req = "INSERT INTO Notification (notification_date, rid, )";

}

