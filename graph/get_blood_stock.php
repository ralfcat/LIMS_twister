<?php
include 'db_connection.php';

$region_id = intval($_GET['rid']); 


// Blood stock levels for each blood type in the selected region
$sql = "
    SELECT 
        bs.blood_type, 
        SUM(bs.stock_level) as total_stock, 
        bs.threshold_level
    FROM Blood_Bank bb
    LEFT JOIN Blood_Stock bs ON bb.blood_bank_id = bs.blood_bank_id
    WHERE bb.region_id = $region_id
    GROUP BY bs.blood_type, bs.threshold_level
    " ;


$result = $link->query($sql);

$blood_types = [];
$stock_levels = [];
$thresholds = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $blood_types[] = $row['blood_type'];
        $stock_levels[] = (int)$row['total_stock'];
        $thresholds[] = (int)$row['threshold_level'];
    }
}

// Return the data as a JSON object
echo json_encode([
    'blood_types' => $blood_types,
    'stock_levels' => $stock_levels,
    'thresholds' => $thresholds
]);

$link->close(); 
?>