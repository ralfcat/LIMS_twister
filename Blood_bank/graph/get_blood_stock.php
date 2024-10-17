<?php
include 'db_connection.php';
include '../bbank_front_page_backend.php';
use function FrontEnd\get_stock as get_stock;
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
    echo "Hello";
    $email = $_GET['email'];
    

    $current_levels = get_stock($email);

    $blood_types = [];
    $stock_levels = [];
    $thresholds = [];

    foreach ($current_levels as $level) {
        $blood_types[] = $level->blood_type;
        $stock_levels[] =  (int)$level->current_stock;
        $thresholds[] = (int) $level->thres_level;
   
    }

     // Return the data as a JSON object
     echo json_encode([
        'blood_types' => $blood_types,
        'stock_levels' => $stock_levels,
        'thresholds' => $thresholds
    ]);
}
