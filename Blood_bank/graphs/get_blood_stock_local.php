<?php
include 'db_connection.php';
include '../bbank_front_page_backend.php';
use function FrontEnd\get_stocks as get_stocks;
use function FrontEnd\get_regional_levels as get_regional_levels;





// Blood stock levels for each blood type in the selected region

if ($_GET['area'] == 'region') {
    $regional_levels = get_regional_levels();

    
    

    $blood_types = [];
    $stock_levels = [];
    $thresholds = [];

    foreach ($regional_levels as $level) {
        $blood_types[] = $level['blood_type'];
        $stock_levels[] = (int)$level['SUM(stock_level)'];
        $thresholds[] = (int)$level['MAX(threshold_level)'];

        
    }

    // if ($result->num_rows > 0) {
    //     while ($row = $result->fetch_assoc()) {
    //         $blood_types[] = $row['blood_type'];
    //         $stock_levels[] = (int)$row['total_stock'];
    //         $thresholds[] = (int)$row['threshold_level'];
    //     }
    // }

    // Return the data as a JSON object
    echo json_encode([
        'blood_types' => $blood_types,
        'stock_levels' => $stock_levels,
        'thresholds' => $thresholds
    ]);

  
} 

else {
    echo "<script>console.log('hello')</script>";
    $email = $_GET['email'];
    

    $current_levels = get_stocks();

    $blood_types = [];
    $stock_levels = [];
    $thresholds = [];

    foreach ($current_levels as $l) {
        $blood_types[] = $l['blood_type'];
        $stock_levels[] =  (int)$l['stock_level'];
        $thresholds[] = $l['threshold_level'];
   
    }

     // Return the data as a JSON object
     echo json_encode([
        'blood_types_local' => $blood_types,
        'stock_levels_local' => $stock_levels,
        'thresholds_local' => $thresholds
    ]);
}
