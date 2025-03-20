<?php
include("header.php");
?>
<?php
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //****************************************************************************************
    // Retrieve a vehicle based on ID
    //****************************************************************************************
    if (isset($_GET['idd']) && is_numeric($_GET['idd'])) {
        $vehicle_id = intval($_GET['idd']);
        $stmt = $pdo->prepare("SELECT * FROM inventory WHERE invId = :id");
        $stmt->bindParam(':id', $vehicle_id, PDO::PARAM_INT);
        $stmt->execute();
        $veh = $stmt->fetch(PDO::FETCH_ASSOC);

        

        if ($veh) {
            //****************************************************************************************
            // Display the selected vehicle data
            //****************************************************************************************
?>

<br>
<div class="container-fluid">
<?php echo '<div class="row">' ?>
            <?php //echo htmlspecialchars($veh['invId']) ?>


<?php echo '<div class="col-xl-8">' ?> 
    <?php echo '<img src="'?>
        <?php echo htmlspecialchars($veh['invImage']) ?>
    <?php echo '"class="main-inv-img">'?>
<?php echo '<br>' ?>
<?php echo '</div>' ?>


<?php echo '<div class="col-xl-4">' ?> 
    <?php echo '<div class="description">'?>
        <?php echo '<h1>'?>
            <?php echo htmlspecialchars($veh['invModel']) ?>
        <?php echo '</h1>'?>

        <?php echo '<h4>$' . htmlspecialchars($veh['invPrice']) . '</h4>'?>
        <?php echo '<h4>' . htmlspecialchars($veh['invMiles']) . ' miles' . '</h4>'?>
        <?php echo '<h4>' . htmlspecialchars($veh['invMpg']) . ' MPG' . '</h4>'?>
        <?php echo '<br>' ?>
        <?php echo htmlspecialchars($veh['invDescription']) ?>
        
    <?php echo '</div>'?>
<?php echo '</div>' ?>
        </div>

    <?php
        } else {
            echo "Vehicle not found";
        }
    } else {
        echo "Invalid vehicle ID.";
    }


} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>


<?php
include("footer.php");
?>


