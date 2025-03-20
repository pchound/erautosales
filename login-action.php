<?php


session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "Form submitted.<br>";
}

//Get form data
    $passwordInput = $_POST['password'];
    $emailInput = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

// Debugging database connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    echo "Database connected.<br>";

    $stmt = $conn->prepare("SELECT id, email, password FROM user WHERE email = :email");
    $stmt->bindParam(':email', $emailInput);
    $stmt->execute();
    $user = $stmt->fetch();


   /* if ($user) {
        echo "User found: " . $user['email'] . "<br>";
    } else {
        echo "User not found.<br>";
    }*/

   /* if ($user) {
        echo "Input password: $passwordInput<br>";
        //echo "Database hash: " . $user['password'] . "<br>";
    
        if (password_verify($passwordInput, $user['password'])) {
            echo "Password verified successfully!<br>";
        } else {
            echo "Password does NOT match!<br>";
        }
    } else {
        echo "User not found.";
    }*/
    
    if ($user && password_verify($passwordInput, $user['password'])) {
        echo "Password verified.<br>";
        session_regenerate_id(true);
        $_SESSION['loggedin'] = true;
        $_SESSION['login_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['last_activity'] = time();


        //For plain text passwords. Not important
        /*if ($user && $passwordInput === $user['password']) {
            session_regenerate_id(true);
            $_SESSION['loggedin'] = true;
            $_SESSION['login_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['last_activity'] = time();*/

        echo "Redirecting to admin-dashboard.php...<br>";
        header("Location: admin-dashboard.php");
        exit;
    } else {
        echo "Authentication failed.<br>";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}

