<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "twister";

// Create connection to the database
$link = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (mysqli_connect_error()) { 
    die("Connection failed: " . mysqli_connect_error());  
}

// Display data in an HTML table
echo '<table border="1"><tr><th>Donor ID</th><th>Name</th><th>Blood Type</th><th>Donation Date</th></tr>';

// SQL query to fetch data from the donors table
$sql = "SELECT donors.id, donors.name, blood_type.type AS blood_type, donations.donation_date 
        FROM donors 
        JOIN blood_type ON donors.blood_type_id = blood_type.id
        JOIN donations ON donors.id = donations.donor_id";

$result = $link->query($sql);

// Check if there are results and display them
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr> <td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["blood_type"] . "</td><td>" . $row["donation_date"] . "</td></tr>";
    }
} else {
    echo "<tr><td colspan='4'>No results found</td></tr>";
}

echo '</table>';

// Close connection
mysqli_close($link);
?>
