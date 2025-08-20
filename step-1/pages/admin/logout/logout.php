<?php
// Start the session
session_start();

// Destroy the session, logging the user out
session_unset();    // Unset all session variables
session_destroy();  // Destroy the session

// Redirect to login page
header("Location: login.php"); // Redirect to your login page or wherever you want
exit();
?>
