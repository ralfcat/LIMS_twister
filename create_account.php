<h1>Donor Register Page</h1>
<form>
    <label for="fname"> First Name</label>
    <input type="text" id="fname"> <br>

    <label for="lname"> Last Name</label>
    <input type="text" id="lname"> <br>

    <label for="address"> Address</label>
    <select id="address">
        <!-- Change this so that the regions comes from the database -->
        <option value="Stockholm">Stockholm</option>
        <option value="Jönköping">Jönköping</option>
        <option value="Kalmar">Kalmar</option>
    </select> <br>

    <label for="age"> Age</label>
    <input type="number" id="age"> <br>

    <label for="email"> Email</label>
    <input type="text" id="email"> <br>

    <label for="password"> Password</label>
    <input type="password" id="password"> <br>

    <label for="re-password"> Re-type Password</label>
    <input type="password" id="re-password"> <br>

    <label for="btype"> Blood Type</label>
    <select id="btype">
        <option value="o-">O-</option>
        <option value="o+">O+</option>
        <option value="b-">B-</option>
        <option value="b+">B+</option>
        <option value="a-">A-</option>
        <option value="a+">A+</option>
        <option value="ab-">AB-</option>
        <option value="ab+">AB+</option>
        <option value="idk">Unsure</option>
    </select> <br>

    <label for="donated"> Have you donated blood before?</label>
    <select id="donated">
        <option value="n">No</option>
        <option value="y">Yes</option>
        <option value="yt">Yetts</option>
    </select> <br>

    <input type="submit" value="Register">





</form>