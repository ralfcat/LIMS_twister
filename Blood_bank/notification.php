<?php
namespace notification;

// Start the session and check if the user is logged in
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: bb_log_out.php');
    exit();
}

// Get the email from the session
$email = $_SESSION['email'] ?? null;

// Database connection function
function open_db() {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "twister";

    $link = new mysqli($servername, $username, $password, $dbname);

    // Check if connection is successful
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }
    return $link;
}

// Fetch notification log from database
function get_notification_log() {
    $link = open_db();
    $query = "SELECT notification_date, people_notified FROM Notification_Log ORDER BY notification_date DESC";
    $result = $link->query($query);

    $notifications = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row;
        }
    }
    $link->close();
    return $notifications;
}

// Debug function to log data in the console
function write_console($data) {
    $output = json_encode($data);
    echo "<script>console.log($output);</script>";
}

// Check if a POST request is made to update thresholds or notifications
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to_do = $_POST["to_do"];
    if ($to_do == "update_notification") {
        $confirm = $_POST['Confirm'] ?? null;
        $unconfirmed = $_POST['UnConfirmed'] ?? null;
        update_notification_log($confirm, $unconfirmed);
    } elseif ($to_do == "update_threshold") {
        foreach ($_POST as $key => $value) {
            if (preg_match('/^(O|A|B)/', $key)) {
                update_thresholds($key, $value);
            }
        }
        header('Location: bbank_notification_log.php');
        exit();
    }
}

// Function to update notification log
function update_notification_log($confirmed, $unconfirmed) {
    // Logic to update notification log based on confirmed and unconfirmed counts
    write_console("Notification updated: Confirmed $confirmed, Unconfirmed $unconfirmed");
}

// Function to update blood type thresholds
function update_thresholds($blood_type, $threshold) {
    $link = open_db();
    $id = get_id();
    $query = "UPDATE Blood_Stock SET threshold_level = ? WHERE blood_bank_id = ? AND blood_type = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("iis", $threshold, $id, $blood_type);
    $stmt->execute();
    $stmt->close();
    $link->close();
    write_console("Threshold for $blood_type updated to $threshold");
}

// Function to get the blood bank ID
function get_id() {
    global $email;
    $link = open_db();
    $query = "SELECT blood_bank_id FROM Blood_Bank WHERE email = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id);
    $stmt->fetch();
    $stmt->close();
    $link->close();
    return $id;
}

// Fetch the notification log data
$notifications = get_notification_log();
?>

