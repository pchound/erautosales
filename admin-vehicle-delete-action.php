<?php

//****************************************************************************************
//*
//*       Name: admin-user-delete-action.php
//*       Author: Joseph Garner
//*       Date: 05-31-2024
//*       Version: 1.00
//*       Purpose: An action that allows the user to delete a requested user
//*
//****************************************************************************************

//****************************************************************************************
//* Database configuration
//****************************************************************************************
include("connection.php");

try{
//****************************************************************************************
// Create PDO connection
//****************************************************************************************
$pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //****************************************************************************************
    //Check if user ID is provided and valid
    //****************************************************************************************
    if(isset($_POST['invId']) && is_numeric($_POST['invId'])){
        $vehicle_id = $_POST['invId'];

        //****************************************************************************************
        //Prepare and execute DELETE query
        //****************************************************************************************
        $stmt = $pdo->prepare("DELETE FROM inventory WHERE invId = :invId");
        $stmt->bindParam(':invId', $vehicle_id);
        $stmt->execute();

        //****************************************************************************************
        //Redirect back to user list with success message
        //****************************************************************************************
        header("Location: admin-vehicle-list.php");
        exit();
    }else{
        //****************************************************************************************
        // Redirect back to user list with error message if ID is not provided or invalid
        //****************************************************************************************
        header("Location: admin-vehicle-list.php?error=1");
        //echo "Error!";
        exit();
    }
}catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}
?>