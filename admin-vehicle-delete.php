<?php
//****************************************************************************************
//*
//*       Name: admin-user-delete.php
//*       Author: Joseph Garner
//*       Date: 12/02/2024
//*       Version: 1.00
//*       Purpose: A form that the user fills to delete a user
//*
//****************************************************************************************

//****************************************************************************************
// Start the session
//****************************************************************************************
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    // Subscriber is logged in
} else {
    echo "Sorry you are not authorized to view this page";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Vehicle</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<br>

<div class="container mt-5">
    <h2>Delete Vehicle</h2><br>
    <?php
//****************************************************************************************
// Database connection
//****************************************************************************************
include("connection.php");

//****************************************************************************************
//* Via try connect to database and loop through users
//****************************************************************************************
    try {
    //****************************************************************************************
	// Create PDO connection
	//****************************************************************************************
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         // Retrieve user data based on ID
         if (isset($_GET['idd']) && is_numeric($_GET['idd'])) {
            $inv_id = intval($_GET['idd']);
            $stmt = $pdo->prepare("SELECT * FROM inventory WHERE invId = :invId");
            $stmt->bindParam(':invId', $inv_id, PDO::PARAM_INT);
            $stmt->execute();
            $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($vehicle) {
                // Display edit form with user data
                ?>

                <form action="admin-vehicle-delete-action.php" method="POST">
                    <input type="hidden" name="invId" value="<?php echo htmlspecialchars($vehicle['invId']); ?>">
                    <input type="hidden" name="invImage" value="<?php echo htmlspecialchars($vehicle['invImage']); ?>">
                    <input type="hidden" name="invThumbnail" value="<?php echo htmlspecialchars($vehicle['invThumbnail']); ?>">
                    <input type="hidden" name="classificationId" value="<?php echo htmlspecialchars($vehicle['classificationId']); ?>">

                    <div class="row">
                        <div class="form-group col-md-6">
                            Image:
                            <?php if (!empty($vehicle['invImage'])): ?>
                                <img src="<?php echo htmlspecialchars($vehicle['invImage']); ?>" class="main-inv-img" id="invImage" name="invImage" alt="Vehicle Image" style="max-width: 50%; height: auto;">
                            <?php else: ?>
                                <p>No image available</p>
                            <?php endif; ?>
                            <br>
                        </div>

                        <div class="form-group col-md-6">
                            Thumbnail:
                            <?php if (!empty($vehicle['invThumbnail'])): ?>
                                <img src="<?php echo htmlspecialchars($vehicle['invThumbnail']); ?>" class="main-inv-img" id="invThumbnail" name="invThumbnail" alt="Vehicle Thumbnail" style="max-width: 100%; height: auto;">
                            <?php else: ?>
                                <p>No thumbnail available</p>
                            <?php endif; ?>
                            <br>
                        </div>
                    </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="year">Year:</label>
                                <input type="text" class="form-control" id="invYear" name="invYear" value="<?php echo htmlspecialchars($vehicle['invYear']); ?>" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="make">Make:</label>
                                <input type="text" class="form-control" id="invMake" name="invMake" value="<?php echo htmlspecialchars($vehicle['invMake']); ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="model">Model:</label>
                                <input type="text" class="form-control" id="invModel" name="invModel" value="<?php echo htmlspecialchars($vehicle['invModel']); ?>" readonly>
                            </div> 

                            <div class="form-group col-md-6">
                                <label for="price">Price:</label>
                                <input type="text" class="form-control" id="invPrice" name="invPrice" value="<?php echo htmlspecialchars($vehicle['invPrice']); ?>" readonly>
                            </div>
                        </div>
                              

                              
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="miles">Miles:</label>
                                <input type="text" class="form-control" id="invMiles" name="invMiles" value="<?php echo htmlspecialchars($vehicle['invMiles']); ?>" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="miles">MPG:</label>
                                <input type="text" class="form-control" id="invMpg" name="invMpg" value="<?php echo htmlspecialchars($vehicle['invMpg']); ?>" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="stock">Stock:</label>
                                <input type="text" class="form-control" id="invStock" name="invStock" value="<?php echo htmlspecialchars($vehicle['invStock']); ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="color">Color:</label>
                                <input type="text" class="form-control" id="invColor" name="invColor" value="<?php echo htmlspecialchars($vehicle['invColor']); ?>" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="category" class="form-label">Category:</label>
                                <select class="form-select" id="invCategory" name="invCategory" required>
                                <?php
                                //****************************************************************************************
                                // Fetch categories for the select dropdown
                                //****************************************************************************************
                                $classification_stmt = $pdo->query("SELECT id, category FROM classification");
                                if ($classification_stmt) {
                                    while ($classification = $classification_stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $selected = ($vehicle['invCategory'] == $classification['category']) ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($classification['category']) . "' $selected>" .
                                        htmlspecialchars($classification['category']) . "</option>";
                                    }
                                } else {
                                    echo "Failed to fetch categories.";
                                }
                                ?>
                            </select>

                            </div>
                            </div>
                            <label for="description">Description:</label>
                            <textarea type="text" class="form-control" id="invDescription" name="invDescription" readonly><?php echo htmlspecialchars($vehicle['invDescription']); ?></textarea>
                    <br>
                    <center>
                        <button type="submit" class="btn" style="background-color:#a41003; color:white;">Delete Vehicle</button>
                        <a href="admin-vehicle-list.php"><button type="button" class="btn" style="background-color:#a41003; color:white;">Cancel</button></a>
                    </center>
                </form>
<br>
                <?php
            } else {
                echo "Vehicle not found.";
            }
        } else {
            echo "Invalid vehicle ID.";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>
</div>
</body>
</html>
