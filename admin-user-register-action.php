<?php

//****************************************************************************************
//*
//*       Name: register-action.php
//*       Author: Joseph Garner
//*       Date: 06-05-2024
//*       Version: 1.00
//*       Purpose: The action request for when a user registers themselves
//*
//****************************************************************************************


include("connection.php");

try {
    //****************************************************************************************
    // Create PDO connection
    //****************************************************************************************
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

    //****************************************************************************************
    // Set PDO error mode to exception
    //****************************************************************************************
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //****************************************************************************************
    //Get form data
    //****************************************************************************************
    $email = $_POST['email'];
    $password = $_POST['password'];

    //****************************************************************************************
    // Hash the password
    //****************************************************************************************
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    //****************************************************************************************
    // Prepare SQL statement to insert data
    //****************************************************************************************
    $stmt = $conn->prepare("INSERT INTO user (email, password) VALUES (:email, :password)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);

    //****************************************************************************************
    // Execute the statement
    //****************************************************************************************
    $stmt->execute();

    //****************************************************************************************
    // Redirect to success page
    //****************************************************************************************
    header("Location: admin-dashboard.php");
    exit;

} catch (PDOException $e) {
    //****************************************************************************************
    // Handle database errors
    //****************************************************************************************
    $errorMessage = "Database error: " . $e->getMessage();
    echo $errorMessage;
    
    //****************************************************************************************
    // You can redirect to an error page or display a user-friendly message here
    //****************************************************************************************
}
?>