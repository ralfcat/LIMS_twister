<?php

namespace Unsubscribe;
// Functions related to donor temporarily unsubscribing from email notifs
function remove_unsub()
{
    include 'graph/db_connection.php';

    $sql = "SELECT * FROM `Donor` WHERE unsubscribe_date IS NOT NULL";
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $email = $row['email'];
            $unsub_date = $row['unsubscribe_date'];
            $curr_date = date("Y-m-d");

            if ($unsub_date < $curr_date) {
                $update_req = "UPDATE Donor SET unsubscribe_date = NULL
                            WHERE email = ?";
                $stmt = $link->prepare($update_req);
                $stmt->bind_param("s", $email);
                if ($stmt->execute()) {
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
            }
        }
    }
    $link->close();
}

function set_unsub_date($email, $date)
{
    include 'graph/db_connection.php';

    $update_req = "UPDATE Donor SET unsubscribe_date = ?
                            WHERE email = ?";
    $stmt = $link->prepare($update_req);
    $stmt->bind_param("ss", $date, $email);
    $stmt->execute();
    return;
  
}

function subscribe($email)
{
    include 'graph/db_connection.php';

    $update_req = "UPDATE Donor SET unsubscribe_date = null
                            WHERE email = ?";
    $stmt = $link->prepare($update_req);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    return;
  
}

function get_unsub_date($email)
{
    include 'graph/db_connection.php';

    $sql = "SELECT unsubscribe_date FROM `Donor` WHERE email = '$email'";
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $unsub_date = $row['unsubscribe_date'];
            if ($unsub_date == null) {
                $link->close();
   
                return -1;
            } else {
                $link->close();

                return $unsub_date;
            }
        }
    }
}
