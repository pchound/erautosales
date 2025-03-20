<?php
include("header.php");

try {
    // Database connection
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the main content
    $stmt = $pdo->prepare("SELECT contactSentence FROM contact LIMIT 1");
    $stmt->execute();
    $about = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<div class='main'>";
    if ($about && isset($about['contactSentence'])) {
        echo $about['contactSentence']; // Output raw HTML content
    } else {
        echo "<p>No content available.</p>";
    }
    echo "</div>";

} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

// Close the connection
$pdo = null;
?>

<style>
    /* Default styling for lists */

        /* Styling for the .main container */
    .main {
      
      
    }

    ul {
        list-style-type: disc;
        margin-left: 20px;
    }
    ol {
        list-style-type: decimal;
        margin-left: 20px;
    }
    li {
        margin-bottom: 5px;
    }
</style>

<?php include("footer.php"); ?>
