<?php
include '../../graph/db_connection.php';

// Fetch blood centers
$sql = "SELECT blood_bank_id, region_id FROM Blood_Bank"; // Ensure to fetch blood_bank_id
$result = $link->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $blood_bank_id = $row['blood_bank_id']; // Get blood_bank_id
        $region_id = $row['region_id'];

        // Define blood types and lower thresholds 
        $blood_types = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $thresholds = [
            1 => ['A+' => 120, 'A-' => 40, 'B+' => 20, 'B-' => 7, 'AB+' => 6, 'AB-' => 4, 'O+' => 125, 'O-' => 45],
            2 => ['A+' => 130, 'A-' => 40, 'B+' => 35, 'B-' => 10, 'AB+' => 15, 'AB-' => 5, 'O+' => 130, 'O-' => 40],
            3 => ['A+' => 110, 'A-' => 40, 'B+' => 30, 'B-' => 20, 'AB+' => 10, 'AB-' => 5, 'O+' => 100, 'O-' => 50],
            4 => ['A+' => 178, 'A-' => 55, 'B+' => 40, 'B-' => 10, 'AB+' => 10, 'AB-' => 10, 'O+' => 160, 'O-' => 50],
            5 => ['A+' => 150, 'A-' => 60, 'B+' => 30, 'B-' => 4, 'AB+' => 8, 'AB-' => 15, 'O+' => 160, 'O-' => 50],
            6 => ['A+' => 130, 'A-' => 40, 'B+' => 35, 'B-' => 10, 'AB+' => 15, 'AB-' => 5, 'O+' => 130, 'O-' => 40],
            7 => ['A+' => 185, 'A-' => 60, 'B+' => 20, 'B-' => 5, 'AB+' => 3, 'AB-' => 2, 'O+' => 190, 'O-' => 77],
            8 => ['A+' => 138, 'A-' => 71, 'B+' => 20, 'B-' => 5, 'AB+' => 5, 'AB-' => 1, 'O+' => 174, 'O-' => 60],
            9 => ['A+' => 140, 'A-' => 55, 'B+' => 40, 'B-' => 10, 'AB+' => 8, 'AB-' => 3, 'O+' => 160, 'O-' => 50],
            10 => ['A+' => 178, 'A-' => 55, 'B+' => 40, 'B-' => 10, 'AB+' => 7, 'AB-' => 2, 'O+' => 132, 'O-' => 35],
            11 => ['A+' => 480, 'A-' => 205, 'B+' => 118, 'B-' => 50, 'AB+' => 39, 'AB-' => 26, 'O+' => 490, 'O-' => 235],
            12 => ['A+' => 800, 'A-' => 300, 'B+' => 200, 'B-' => 80, 'AB+' => 100, 'AB-' => 50, 'O+' => 800, 'O-' => 350],
            13 => ['A+' => 130, 'A-' => 40, 'B+' => 35, 'B-' => 10, 'AB+' => 15, 'AB-' => 5, 'O+' => 130, 'O-' => 40],
            14 => ['A+' => 130, 'A-' => 40, 'B+' => 35, 'B-' => 10, 'AB+' => 15, 'AB-' => 5, 'O+' => 130, 'O-' => 40],
            15 => ['A+' => 130, 'A-' => 40, 'B+' => 35, 'B-' => 10, 'AB+' => 15, 'AB-' => 5, 'O+' => 130, 'O-' => 40],
            16 => ['A+' => 130, 'A-' => 40, 'B+' => 35, 'B-' => 10, 'AB+' => 15, 'AB-' => 5, 'O+' => 130, 'O-' => 40],
            17 => ['A+' => 130, 'A-' => 40, 'B+' => 35, 'B-' => 10, 'AB+' => 15, 'AB-' => 5, 'O+' => 130, 'O-' => 40],
            18 => ['A+' => 130, 'A-' => 40, 'B+' => 35, 'B-' => 10, 'AB+' => 15, 'AB-' => 5, 'O+' => 130, 'O-' => 40],
            19 => ['A+' => 130, 'A-' => 40, 'B+' => 35, 'B-' => 10, 'AB+' => 15, 'AB-' => 5, 'O+' => 130, 'O-' => 40],
            20 => ['A+' => 130, 'A-' => 40, 'B+' => 35, 'B-' => 10, 'AB+' => 15, 'AB-' => 5, 'O+' => 130, 'O-' => 40],
            21 => ['A+' => 130, 'A-' => 40, 'B+' => 35, 'B-' => 10, 'AB+' => 15, 'AB-' => 5, 'O+' => 130, 'O-' => 40],
        ];

        // Prepare the insert statement outside the loop
        $insert_sql = "INSERT INTO blood_stock (blood_bank_id, blood_type, stock_level, threshold_level) 
                       VALUES (?, ?, ?, ?)
                       ON DUPLICATE KEY UPDATE stock_level = ?, threshold_level = ?"; // Ensure this refers to a unique key

        $stmt = $link->prepare($insert_sql);

        foreach ($blood_types as $blood_type) {
            $lower_limit = $thresholds[$region_id][$blood_type];
            // Calculate the range: 50% under and 50% over the lower limit
            $min_stock = floor($lower_limit * 0.5); // 50% under
            $max_stock = ceil($lower_limit * 1.5); // 50% over
            
            // Generate random stock level within the specified range
            $stock_level = rand($min_stock, $max_stock); 

            // Bind parameters for the prepared statement
            $stmt->bind_param("isiiii", $blood_bank_id, $blood_type, $stock_level, $lower_limit, $stock_level, $lower_limit);

            // Execute the prepared statement
            if (!$stmt->execute()) {
                echo "Error inserting for Blood Bank ID: $blood_bank_id, Blood Type: $blood_type - " . $stmt->error . "<br>";
            }
        }

        // Close the prepared statement
        $stmt->close();
    }
    echo "Blood stock data inserted successfully!";
} else {
    echo "No blood centers found.";
}

// Close the connection
$link->close();
?>

