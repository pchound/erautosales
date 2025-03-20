<?php
include("header.php");

try {
    // Debugging: Validate connection
    echo "<!-- Debug: Attempting database connection -->";
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<!-- Debug: Database connection successful -->";

    

    // Fetch inventory items
    $stmt = $pdo->prepare("SELECT * FROM inventory LIMIT 3");
    $stmt->execute();
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<div class="container">';
    echo '<div class="row">';

    foreach ($inventory as $vehicle) {
        $uid = htmlspecialchars($vehicle['invId']);
        echo "<div class='col-md'>";
        echo "<a href='view-vehicle.php?idd=$uid'>";
        echo "<img src='" . htmlspecialchars($vehicle['invThumbnail']) . "' alt='Image of " . htmlspecialchars($vehicle['invMake']) . " " . htmlspecialchars($vehicle['invModel']) . "'>";
        echo "<h2>" . htmlspecialchars($vehicle['invMake']) . "</h2>";
        echo "<h4>$" . htmlspecialchars($vehicle['invPrice']) . "</h4>";
        echo "</a>";
        echo "</div>";
    }

    echo '</div>';
    echo '</div>';

} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

// Close the connection
$pdo = null;
?>



<?php
include("footer.php");
?>
