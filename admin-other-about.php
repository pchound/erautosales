<?php
//****************************************************************************************
//* Name: admin-other-about.php
//* Author: Joseph Garner
//* Date: 12/02/2024
//* Version: 1.06
//* Purpose: A form to edit the aboutSentence in the database using Trumbowyg.
//****************************************************************************************

// "admin-other-contact.php" and "admin-other-about.php" are the
// only two files that don't use "include admin-session" due to a weird
// glitch. So I have no choice but to edit the session data manually on these
// two files.

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

// Include database connection
include("connection.php");

try {
    // Database connection
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the existing aboutSentence
    $stmt = $pdo->prepare("SELECT aboutSentence FROM about LIMIT 1");
    $stmt->execute();
    $about = $stmt->fetch(PDO::FETCH_ASSOC);

    // Content from database
    $existingContent = $about ? $about['aboutSentence'] : "";
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Connection failed: " . $e->getMessage() . "</div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit About Sentence</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Trumbowyg CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trumbowyg/dist/ui/trumbowyg.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit About Sentence</h2>
    <form method="POST" action="admin-other-about-action.php">
        <div class="mb-3">
            <label for="aboutSentence" class="form-label">About Sentence</label>
            <!-- Trumbowyg replaces this textarea -->
            <textarea id="aboutSentence" name="aboutSentence"><?php echo htmlspecialchars($existingContent); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="admin-dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- Trumbowyg JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/trumbowyg/dist/trumbowyg.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/trumbowyg/dist/plugins/align/trumbowyg.align.min.js"></script>

<script>
    // Initialize Trumbowyg Editor
    $(document).ready(function() {
        $('#aboutSentence').trumbowyg({
            btns: [
                ['bold', 'italic', 'underline'], // Basic formatting
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'], // Alignment
                ['unorderedList', 'orderedList'], // Lists
                ['link'], // Links
                ['fullscreen'] // Fullscreen editor
            ],
            autogrow: true // Automatically expand editor height
        });
    });
</script>
</body>
</html>
