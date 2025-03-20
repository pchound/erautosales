<?php
include("admin-header.php");

session_start();
// Function to print session data
function printSessionData() {
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';
}
define('INACTIVITY_TIMEOUT', 600); // Timeout in seconds (e.g., 600 seconds = 10 minutes)

// Check if the user is logged in
if (!isset($_SESSION['login_id'])) {
    echo "Access denied";
    /*header("Location: login.php");*/
    exit;
}
// Check for inactivity
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > INACTIVITY_TIMEOUT)) {
    // Last activity was more than the timeout period ago
    session_unset(); // Unset session variables
    session_destroy(); // Destroy the session
    header("Location: login.php?message=Session expired due to inactivity.");
    exit;
}

// Update last activity time stamp
$_SESSION['last_activity'] = time();
// printSessionData();
?>