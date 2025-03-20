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
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $user_id = $_GET['id'];

        //****************************************************************************************
        //Prepare and execute DELETE query
        //****************************************************************************************
        $stmt = $pdo->prepare("DELETE FROM user WHERE id = :id");
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();

        //****************************************************************************************
        //Redirect back to user list with success message
        //****************************************************************************************
        header("Location: admin-user-list.php");
        exit();
    }else{
        //****************************************************************************************
        // Redirect back to user list with error message if ID is not provided or invalid
        //****************************************************************************************
        header("Location: admin-user-list.php?error=1");
        //echo "Error!";
        exit();
    }
}catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}
?>