<body>

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

        <label for="sex"> Sex</label>
        <select id="sexes" onchange="check_preg()">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            
        </select> 

        <label for="preggo" id="pr"></label>
        <select hidden id="preg">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select> <br>

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
        <select id="donateds" onchange="last_donated_date()">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select> 

        <label for="donate-date" id="dn"></label>
        <input type="hidden" id="donate-date"> <br>

        <input type="submit" value="Register">
        <p id="demo"></p>





    </form>

</body>

<script>
function last_donated_date() {
    var donated = document.getElementById("donateds").value;
    if (donated === "No") {
        document.getElementById("dn").innerHTML = ''
        document.getElementById("donate-date").type = 'hidden'
    } else {
        document.getElementById("dn").innerHTML = 'When did you last donate?'
        document.getElementById("donate-date").type = 'date'
    }
}

function check_preg() {
    let sel = document.getElementById('preg');
    let label = document.getElementById('pr');
    let hidden = sel.getAttribute("hidden");
    var sex = document.getElementById("sexes").value;
    if (sex === "Female") {
        sel.removeAttribute("hidden");
        label.innerHTML = 'Are you pregnant or breastfeeding?';

    } else {
        sel.setAttribute("hidden", "hidden");
        label.innerHTML = '';
    }
}
</script>