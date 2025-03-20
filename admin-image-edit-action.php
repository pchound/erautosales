<?php
//****************************************************************************************
//*
//*       Name: register-action.php
//*       Author: Joseph Garner
//*       Date: 06-05-2024
//*       Version: 1.02
//*       Purpose: The action request for replacing the image in the database and backend
//*
//****************************************************************************************

include("connection.php");

try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if an existing record exists
    $stmt = $conn->prepare("SELECT mainImg FROM mainimg LIMIT 1");
    $stmt->execute();
    $existingRecord = $stmt->fetch(PDO::FETCH_ASSOC);

    $currentImagePath = null;
    if ($existingRecord) {
        $currentImagePath = $existingRecord['mainImg'];
    }

    // Process uploaded image
    $imagePath = null; // Initialize the image path variable
    if (isset($_FILES['mainImage']) && $_FILES['mainImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "er-img/main-img/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
        }

        $fileTmpPath = $_FILES['mainImage']['tmp_name'];
        $fileName = uniqid('main_') . '.' . strtolower(pathinfo($_FILES['mainImage']['name'], PATHINFO_EXTENSION));
        $imagePath = $uploadDir . $fileName;

        // Validate file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $fileType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        if (!in_array($fileType, $allowedTypes)) {
            die("Error: Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.");
        }

        // Move the uploaded file to the designated directory
        if (!move_uploaded_file($fileTmpPath, $imagePath)) {
            die("Error: Failed to upload the image.");
        }

        // Delete the old image file if it exists
        if ($currentImagePath && file_exists($currentImagePath)) {
            unlink($currentImagePath);
        }
    } else {
        die("Error: No image uploaded.");
    }

    // Update or insert the new image path in the database
    if ($existingRecord) {
        // Update existing record
        $stmt = $conn->prepare("UPDATE mainimg SET mainImg = :mainImg WHERE mainImg = :currentImg");
        $stmt->bindParam(':mainImg', $imagePath);
        $stmt->bindParam(':currentImg', $currentImagePath);
    } else {
        // Insert new record if none exists
        $stmt = $conn->prepare("INSERT INTO mainimg (mainImg) VALUES (:mainImg)");
        $stmt->bindParam(':mainImg', $imagePath);
    }

    // Execute the query
    $stmt->execute();

    // Redirect to success page
    header("Location: admin-image-edit.php");
    exit;

} catch (PDOException $e) {
    // Handle database errors
    $errorMessage = "Database error: " . $e->getMessage();
    echo $errorMessage;
}
?>
