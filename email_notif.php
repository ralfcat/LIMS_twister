<?php

namespace EmailNotif;

require_once 'Blood_bank/bbank_front_page_backend.php';
require 'Donor/Donor_reg/PHPMailer/src/Exception.php';
require 'Donor/Donor_reg/PHPMailer/src/PHPMailer.php';
require 'Donor/Donor_reg/PHPMailer/src/SMTP.php';
require 'Donor/Donor_reg/config.php';
require_once 'templates/notif_template.php';


use FrontEnd\BloodStock as BloodStock;
use function FrontEnd\get_user_id as get_user_id;
use function FrontEnd\get_region_id as get_region_id;
use function FrontEnd\write_console as write_console;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use function NotifTemplate\notif_email;

class Recipient
{
    public $userid;
    public $date;
    public $address;
    public $name;
    public $blood_type;
    public $email;

    public function __construct($userid, $date, $address, $name, $blood_type, $email)
    {
        $this->userid = $userid;
        $this->date = $date;
        $this->address = $address;
        $this->name = $name;
        $this->blood_type = $blood_type;
        $this->email = $email;
    }
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


function send_emails(array $blood_levels, $rid, $bid)
{
    foreach ($blood_levels as $level) {
        $curr_stock = $level->current_stock;
        $thresh = $level->thres_level;
        $type = $level->blood_type;

        if ($curr_stock < $thresh) {
            $mail_list = get_mail_list($type, $rid);
            populate_notif_db($mail_list, $bid);
        }
    }
   
  
    
}


function sendMail(Recipient $user)
{

    $btype = $user->blood_type;
    $address = $user->address;
    $email = $user->email;
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = MAILHOST;
    $mail->Username = USERNAME;
    $mail->Password = PASSWORD;
    $mail->SMTPSecure = 'tls';

    $mail->Port = 587;
    $mail->setFrom(SEND_FROM, SEND_FROM_NAME);
    $mail->addAddress($email);
    $mail->addReplyTo(REPLY_TO, REPLY_TO_NAME);
    $mail -> CharSet = 'UTF-8';
    $mail->isHTML(true);
    
    $mail->Subject = "Running low on $btype in $address";
    $mail->Body = notif_email($btype, $address);
    $mail->AltBody = 'Hej! We are running low on ' . $btype . ' in ' . $address . '! Visit your local blood center to donate';
    
    if (!$mail->send()) {
        return -1;
    } else {

        return 0;
    }
}


// Get the list of people that will be sent an email as an array, and the number of people that will be sent an email
function get_mail_list($btype, $rid)
{
    global $link;
    $sql_que = "SELECT blood_type, donor_id, name, email, address, is_eligible, blood_type from Donor 
    where address IN (SELECT region from Region WHERE rid = $rid) AND is_eligible = 1 AND blood_type = '$btype'
    AND unsubscribe_date IS NULL";
    $sql_request = $link->query($sql_que);


    $mail_list = array();
    while ($row = $sql_request->fetch_assoc()) {
        $id = $row["donor_id"];

        $reci = new Recipient($id, date('Y-m-d H:i:s'), $row['address'], $row['name'], $row['blood_type'], $row['email']);
        $mail_list[] = $reci;
    }
    $l = sizeof($mail_list);
    return $mail_list;
}

function populate_notif_db($mail_list, $bid)
{
    global $link;

    // create the message for the log
    foreach ($mail_list as $mailer) {
        sendMail($mailer);
        $user_id = $mailer->userid;
        $date = $mailer->date;
        $rid = get_region_id($mailer->address);


        $sql_req = "INSERT INTO Notification (notification_date, rid, donor_id, blood_bank_id) VALUES (?,?,?, ?)";
        $stmt = $link->prepare($sql_req);

        $stmt->bind_param("siii", $date, $rid, $user_id, $bid);
        $stmt->execute();
    }

    return;
}
