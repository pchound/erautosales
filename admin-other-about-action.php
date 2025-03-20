<?php
//****************************************************************************************
//* Name: admin-other-about-action.php
//* Author: Joseph Garner
//* Date: 12/02/2024
//* Version: 1.06
//* Purpose: Processes the form submission for editing aboutSentence in the database.
//****************************************************************************************

// Start the session
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "Sorry, you are not authorized to perform this action.";
    exit;
}

// Include database connection
include("connection.php");

try {
    // Database connection
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['aboutSentence'])) {
            // Retrieve the input (raw HTML from Trumbowyg)
            $aboutSentence = trim($_POST['aboutSentence']);

            // Update the database
            $stmt = $pdo->prepare("UPDATE about SET aboutSentence = :aboutSentence LIMIT 1");
            $stmt->bindParam(':aboutSentence', $aboutSentence, PDO::PARAM_STR);
            $stmt->execute();

            // Success message and redirect
            $_SESSION['success'] = "About sentence updated successfully.";
            header('Location: admin-other-about.php');
            exit;
        } else {
            throw new Exception("Form submission error: aboutSentence is missing.");
        }
    } else {
        throw new Exception("Invalid request method.");
    }

} catch (PDOException $e) {
    // Handle database errors
    $_SESSION['error'] = "Database Error: " . $e->getMessage();
    header('Location: admin-other-about.php');
    exit;
} catch (Exception $e) {
    // Handle general errors
    $_SESSION['error'] = "Error: " . $e->getMessage();
    header('Location: admin-other-about.php');
    exit;
}

// Close the connection
$pdo = null;
?>
