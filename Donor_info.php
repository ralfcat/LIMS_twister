<form action="Insertdata_donor.php" method="POST">
    <h2> #Donor ID </h2>
    Name:<input type="text" name="dname"><br>
    Email:<input type="text" name="demail"><br> 
    Password:<input type="text" name="demail"><br> 
    Blood type:<select id="dblood" name="dblood"> <!--Beginning of the drop-down menu-->
    <option value="" disable selected></option> 
    <option value="0+" disable selected></option>
    <option value="0-" disable selected></option>
    <option value="A+" disable selected></option>
    <option value="A-" disable selected></option>
    <option value="B+" disable selected></option>
    <option value="B-" disable selected></option>
    <option value="AB+" disable selected></option>
    <option value="AB-" disable selected></option>
    </select><br>
    Sex:<select id="dsex" name="dsex"> <!--Beginning of the drop-down menu-->
    <option value="" disable selected></option> 
    <option value="Female" disable selected></option>
    <option value="Male" disable selected></option>
    <option value="Other" disable selected></option>
    </select><br>
    Date of birth:<input type="text" name="dbirth"><br> 
    Region:<select id="dregionid" name="dregionid"> <!--Beginning of the drop-down menu-->
    <option value="" disable selected></option> 
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "things"; //Change
    
    // Create connection
    $link = mysqli_connect($servername, $username, $password, $dbname);
    
    // Check if connection is established
    if (mysqli_connect_error()) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //Fetch categories from genres
    $sql = "SELECT gid, mgenre FROM genres"; //Change
    $result = $link->query($sql);

    //Add the categories from genres
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<option value=' " . $row['gid'] . "'>" . $row['mgenre'] . "</option>\n"; //Change
        }
    }

    // Close the database connection
    $link->close();

    ?>
    </select><br>
    <input type="Save changes" value="Add">
</form>

<?php