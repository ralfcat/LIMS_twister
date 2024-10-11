<?php
include 'db_connection.php';

$sql = "SELECT rid, region FROM Region";
$result = $link->query($sql);

$regions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $regions[] = $row; 
    }
}

// Returning all the regions as a JSON object
echo json_encode($regions); 

$link->close(); 
?>
