<?php
// Database connection
include("connection.php");

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Update user data
    $id = $_POST['id'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("UPDATE user SET email = :email WHERE id = :id");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Redirect back to edit screen with success message
    header("Location: admin-user-list.php");
    exit();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>