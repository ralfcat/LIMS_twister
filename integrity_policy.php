<?php
session_start();
$frontpage = "";
if (isset($_SESSION['bbloggedin'])) {
    $frontpage = "Blood_bank/bbank_front_page.php";
} else if (isset($_SESSION['donorlogged'])) {
    $frontpage = "Donor/Donor_profile/donor_front_page_backend.php";
} else {
    $frontpage = "index.php";
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="../../BloodAlert_logo.png">
    <title>Donor Login</title>
    <link rel="stylesheet" href="../../stylesheet/reset.css" />
    <link rel="stylesheet" href="../../stylesheet/styles2.css" />
    <script>
        function validateForm() {
            let email = document.forms["loginform"]["email"].value;
            let password = document.forms["loginform"]["password"].value;
            
            let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            
            document.getElementById("error-message").innerHTML = "";
            document.getElementById("error-message2").innerHTML = "";
            if (email == "") {
                document.getElementById("error-message").innerHTML = "Email must be filled out";
                document.getElementById("error-message").classList.add("error-message");
                return false;
            } else if (!emailPattern.test(email)) {
                document.getElementById("error-message").innerHTML = "Please enter a valid email address";
                document.getElementById("error-message").classList.add("error-message");
                return false;
            }
            if (password == "") {
                document.getElementById("error-message2").innerHTML = "Password must be filled out";
                document.getElementById("error-message").classList.add("error-message");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <header>
        <div class="logo-container">
            <a href = <?php echo $frontpage?>>  <img class="logo" src="../../Logo-and-text.png" alt="Logo"> </a>
        </div>
        <nav>
            <ul>
                <li><a href= <?php echo $frontpage?>>Front Page</a></li>
            </ul>
        </nav>
    </header>

    <h1>Integrity Policy</h1>
    <section class="donation-form">
        <div class="info-container">
            <p>Blood Alert processes a considerable amount of personal and sensitive data, focusing on health 
                information. In accordance with the General Data Protection Regulation regulations, Blood Alert is the 
                data controller and is obligated to inform you about the collection and processing of your personal 
                data. The legal basis for processing your personal data is your consent, in accordance with Article 
                6.1(a). If you have any questions regarding the processing of your personal data, you can contact 
                <a href="mailto:bloodalert.twister@gmail.com">bloodalert.twister@gmail.com</a>. </p>

            <br>
            <h3>What Type of Information We Collect </h3>

            <ul style="list-style-type: circle; padding-left: 40px; list-style-position: outside;">
                <li> <b>Personal Information:</b>
                    <br>
                    We collect details such as your <b>name, sex, region,</b> and <b> email address</b>. This information is 
                    important for enabling the system to match donors with nearby blood banks and to send timely 
                    notifications when blood donations are needed.</li>  
                

                <li> <b>Sensitive Information:</b>
                    <br>
                    We collect your <b>blood type</b> and <b>donation history</b>. Your blood type is necessary to identify when you 
                    may be required to donate a specific type of blood, while your donation history allows the system 
                    to track your most recent donations, helping calculate the next eligible donation date in 
                    compliance with health and safety guidelines. </li>
            </ul>

            <br>
            <h3>Purpose of Processing Personal Data</h3>
            The personal and sensitive data we collect is processed for the following specific purposes:
            <ul style="list-style-type: circle; padding-left: 40px; list-style-position: outside;">
                <li> <b>Communicating with blood donors: </b>
                    <br>
                    To contact donors through notifications or reminders when their blood type is needed.</li>
                <li> <b>Managing donor records:</b>
                    <br>
                    Keeping an updated and secure database of blood donors, ensuring accurate information 
                    for matching with blood bank requirements.</li>
                <li> <b>Health-related reminders: </b>
                    <br>
                    Providing useful reminders about donation eligibility based on donation history and health guidelines.</li>

            </ul>

            <br>
            <h3>How Blood Alert Stores and Processes Your Data</h3>
            <ul style="list-style-type: circle; padding-left: 40px; list-style-position: outside;">
                <li> <b>Purposeful Collection and Use:</b>
                    <br>
                     All collected data serves a clear and defined purpose, ensuring relevance to the system’s 
                    functions. This is in line with <b>Article 4.1</b> of the GDPR, which specifies that data collection 
                    must be adequate, relevant, and limited to what is necessary.</li>
                <li> <b>Data Privacy and Security:</b> 
                    <br>
                    Blood Alert takes the privacy and security of your data seriously. We follow strict technical
                     and organizational measures to ensure your data is protected against unauthorized access, loss, 
                     or misuse, as outlined in <b>Article 32</b> of the GDPR. This includes encrypted storage and secure 
                     processing systems. </li>
                <li> <b>Transparency and Data Access:</b> 
                    <br>
                    In compliance with <b>Articles 13 and 14</b> of the GDPR, we ensure complete transparency regarding how 
                    your data is collected, used, and shared. You have the right to access your personal data at any 
                    time through your account, ensuring control over the information you provide. </li>
            </ul>
            <br>
            <h3>You have the following rights regarding your personal data: </h3>
            <p>Under the GDPR, you are granted several rights to ensure the protection and control of your personal information:</p>
            <ul style="list-style-type: circle; padding-left: 40px; list-style-position: outside;">
                <li> <b>Right to Access (Article 15):</b>
                    <br>
                    You can request a copy of your personal data that we hold and verify how it is being processed.
                </li>
                <li> <b>Right to Correction (Article 16):</b>
                    <br>
                    If any information we hold about you is inaccurate or incomplete, you have the right to request 
                    corrections.</li>
                <li> <b>Right to delete personal data (Article 17):</b>
                    <br>
                    In certain circumstances, you can request that we delete your personal data, for instance, 
                    if it is no longer necessary for the purposes for which it was collected.</li>
                <li> <b>Right to Restriction of Processing (Article 18):</b> 
                    <br>
                    You have the right to request that we limit the processing of your personal data in specific 
                    situations, such as when the accuracy of the data is contested.</li>
                <li> <b>Right to Object (Article 21):</b>
                    You can object to the processing of your personal data in cases where it is based on legitimate 
                    interests, or direct marketing, by contacting us.</li>
                <li> <b>Right to Data Portability (Article 20):</b> 
                    <br>
                    You have the right to receive your personal data in a structured, commonly used, and machine-readable 
                    format and to transfer this data to another service provider.</li>
                <li> <b>Right to Lodge a Complaint (Article 77):</b> 
                    <br>
                    If you believe that your rights have been violated, you have the right to lodge a complaint with 
                    the relevant Data Protection Authority.</li>
                <li> <b>Right to Withdraw Consent (Article 13.2(c) and Article 7):</b>
                    <br>
                    You may withdraw your consent to the processing of your personal data at any time. Withdrawing your 
                    consent does not affect the lawfulness of processing based on consent before its withdrawal. To 
                    withdraw consent, please contact us at <a href="mailto:bloodalert.twister@gmail.com">bloodalert.twister@gmail.com</a></li>
            </ul>
            <br>
            <p>To withdraw your consent, please contact us at <a href="mailto:bloodalert.twister@gmail.com">bloodalert.twister@gmail.com</a>.</p>

        </div>
    </section>
</body>

<footer>
  <p>&copy; 2024 Blood Alert</p>
  <nav>
    <a href="about_us.php">About Us</a> |
    <a href="integrity_policy.php">Integrity Policy</a> |
    <a href="mailto:bloodalert.twister@gmail.com">Contact Us</a>
  </nav>
</footer>
</html>