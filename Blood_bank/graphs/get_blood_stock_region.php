<?php
include 'db_connection.php';





// Blood stock levels for each blood type in the selected region
// $email = $_GET['email']; 
$email = 'admin@admin.com';

$sql = "SELECT blood_type, SUM(stock_level), MAX(threshold_level) 
FROM Blood_Stock WHERE blood_bank_id = ANY (SELECT blood_bank_id FROM Blood_Bank WHERE region_id 
= ANY (SELECT region_id FROM Blood_Bank where email = '$email')) GROUP BY blood_type";


$result = $link->query($sql);



$blood_types = [];
$stock_levels = [];
$thresholds = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
    $blood_types[] = $row['blood_type'];
    $stock_levels[] = (int)$row['SUM(stock_level)'];
    $thresholds[] = (int)$row['MAX(threshold_level)'];
}
}
echo json_encode([
    'blood_types' => $blood_types,
    'stock_levels' => $stock_levels,
    'thresholds' => $thresholds
]);

$link->close(); 
