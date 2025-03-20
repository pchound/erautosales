<?php
include("admin-session.php");
?>

<div class="container mt-5">
    <h2>Edit Vehicle</h2><br>
    <?php
//****************************************************************************************
// Database connection
//****************************************************************************************
include("connection.php");

//****************************************************************************************
//* Via try connect to database and loop through users
//****************************************************************************************

    //****************************************************************************************
	// Create PDO connection
	//****************************************************************************************

    try {
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

<div class="form-center">
                <form action="admin-vehicle-edit-action.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="invId" value="<?php echo htmlspecialchars($vehicle['invId']); ?>">
                    <input type="hidden" name="invImage" value="<?php echo htmlspecialchars($vehicle['invImage']); ?>">
                    <input type="hidden" name="invThumbnail" value="<?php echo htmlspecialchars($vehicle['invThumbnail']); ?>">
                    <input type="hidden" name="invCategory" value="<?php echo htmlspecialchars($vehicle['invCategory']); ?>">


         Vehicle Image
    <div class="mb-1 row justify-content-center ">
        <label for="invImage"></label>
        <?php if (!empty($vehicle['invImage'])): ?>
            <img src="<?php echo htmlspecialchars($vehicle['invImage']); ?>" alt="Current Image" style="max-width: 500px; height: auto;">
        </div>
        <?php else: ?>
            <p>No image available</p>
        <?php endif; ?>
        <br><br>
        <div class="mb-1 row justify-content-center ">
        <input type="file" class="form-control" id="invImage" name="invImage"  style="width: 500px;">
    </div>






      
             

                        <div class="mb-3 row justify-content-center">
                            <div class="form-group col-md-4">
                                <label for="year">Year:</label>
                                <input type="text" class="form-control" id="invYear" name="invYear" value="<?php echo htmlspecialchars($vehicle['invYear']); ?>" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="make">Make:</label>
                                <input type="text" class="form-control" id="invMake" name="invMake" value="<?php echo htmlspecialchars($vehicle['invMake']); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3 row justify-content-center">
                            <div class="form-group col-md-4">
                                <label for="model">Model:</label>
                                <input type="text" class="form-control" id="invModel" name="invModel" value="<?php echo htmlspecialchars($vehicle['invModel']); ?>" required>
                            </div> 

                            <div class="form-group col-md-4">
                                <label for="price">Price:</label>
                                <input type="text" class="form-control" id="invPrice" name="invPrice" value="<?php echo htmlspecialchars($vehicle['invPrice']); ?>" required>
                            </div>
                        </div>
                              

                              
                        <div class="mb-3 row justify-content-center">
                            <div class="form-group col-md-4">
                                <label for="miles">Miles:</label>
                                <input type="text" class="form-control" id="invMiles" name="invMiles" value="<?php echo htmlspecialchars($vehicle['invMiles']); ?>" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="miles">MPG:</label>
                                <input type="text" class="form-control" id="invMpg" name="invMpg" value="<?php echo htmlspecialchars($vehicle['invMpg']); ?>" required>
                            </div>
                        </div>


                        <div class="mb-3 mb-3 row justify-content-center justify-content-center">
                            <div class="form-group col-md-4">
                                <label for="stock">Stock:</label>
                                <input type="text" class="form-control" id="invStock" name="invStock" value="<?php echo htmlspecialchars($vehicle['invStock']); ?>" required>
                            </div>
                        

                            <div class="form-group col-md-4">
                                <label for="year">Year:</label>
                                <input type="text" class="form-control" id="invYear" name="invYear" value="<?php echo htmlspecialchars($vehicle['invYear']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3 row justify-content-center">
                            <div class="form-group col-md-4">
                                <label for="color">Color:</label>
                                <input type="text" class="form-control" id="invColor" name="invColor" value="<?php echo htmlspecialchars($vehicle['invColor']); ?>" required>
                            </div>

                            <div class="form-group col-md-4">
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
                        <div class="mb-3 mb-3 row justify-content-center justify-content-center">
        <div class="col-md-6">
            <label for="invDescription" class="form-label">Description:</label>
            <textarea class="form-control" id="invDescription" name="invDescription" rows="4" style="resize: both;"><?php echo htmlspecialchars($vehicle['invDescription']); ?></textarea>
        </div>
    </div>
</div>
                    <br>
                    <center>
                        <button type="submit" class="btn" style="background-color:#a41003; color:white;">Update Vehicle</button>
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
