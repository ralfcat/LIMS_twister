<?php
include 'db_connection.php';




// Blood stock levels for each blood type in the selected region



    $email = $_GET['email'];

    

    $sql = "SELECT Blood_Stock.* 
    FROM Blood_Bank LEFT JOIN Blood_Stock ON Blood_Stock.blood_bank_id = Blood_Bank.blood_bank_id 
    WHERE Blood_Bank.email = '$email'";

$result = $link->query($sql);

    $blood_types = [];
    $stock_levels = [];
    $thresholds = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
        $blood_types[] = $row['blood_type'];
        $stock_levels[] =  (int)$row['stock_level'];
        $thresholds[] = (int)$row['threshold_level'];
   
    }
}

     // Return the data as a JSON object
     echo json_encode([
        'blood_types' => $blood_types,
        'stock_levels' => $stock_levels,
        'thresholds' => $thresholds
    ]);

