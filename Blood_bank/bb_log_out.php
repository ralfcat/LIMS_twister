<?php
session_start(); // Start the session

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page after logout
header("Location: bbank_log_in.php?err=logged-out");
exit();
?>