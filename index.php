<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "code_grading";

// Create connection
$link = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection is established
if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT gid,mgenre FROM genres";
$result = $link -> query($sql);
?>

<form action="insert_movie.php" method="POST">
    Movie name:<input type="text" name="mname"><br>
    Release year:<input type="text" name="myear"><br>
    Genre: <select name = "mgenreid">
        <?php
        if ($result -> num_rows >0) {
            while ($row = $result -> fetch_assoc()){
                echo "<option value = '" . $row["gid"] . "'>" . $row['mgenre'] . "</option>";
            }
        }
        ?>
    </select>
    <br>
    Rating:<input type="number" name="mrating"><br>
    <input type="submit" value="Add">
</form>
<br>
<br>
<form action="showmovies.php" method="GET">
    <input type="submit" value="Show movies">
</form>