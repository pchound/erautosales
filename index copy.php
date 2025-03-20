<?php
include("header.php");

try {
    // Debugging: Validate connection
    echo "<!-- Debug: Attempting database connection -->";
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<!-- Debug: Database connection successful -->";

    // Fetch the main image
    $stmt = $pdo->prepare("SELECT mainImg FROM mainimg LIMIT 1");
    $stmt->execute();
    $main = $stmt->fetch(PDO::FETCH_ASSOC);

    // Debug: Output mainImg data
    if ($main) {
        echo "<!-- Debug: Fetched mainImg value: " . htmlspecialchars($main['mainImg']) . " -->";

        if (!empty($main['mainImg'])) {
            if (file_exists($main['mainImg'])) {
                echo "<img src='" . htmlspecialchars($main['mainImg']) . "' alt='Main image of a vehicle' id='main-img'>";
            } else {
                echo "<p>File not found: " . htmlspecialchars($main['mainImg']) . "</p>";
            }
        } else {
            echo "<p>No main image available in the database.</p>";
        }
    } else {
        echo "<p>No data found in the 'main' table.</p>";
    }

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

<div class="main">
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
</div>

<?php
include("footer.php");
?>
