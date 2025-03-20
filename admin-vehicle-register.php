<?php
//****************************************************************************************
//*
//*       Name: admin-add-articles.php
//*       Author: Joseph Garner
//*       Date: 05/31/2024
//*       Version: 1.00
//*       Purpose: A form that the user fills to add a new article
//*
//****************************************************************************************




//****************************************************************************************
// Start the session
//****************************************************************************************
session_start();
if ($_SESSION['loggedin'] == true) {
//subscriber is logged in
} else {
echo "Sorry you are not authorized to view this page";
exit;
};
?>




<?php
//****************************************************************************************
//* Database configuration
//****************************************************************************************
include("connection.php");
//****************************************************************************************
//* Via try connect to database and loop through categories and articles
//****************************************************************************************

try {
	//****************************************************************************************
	// Create PDO connection
	//****************************************************************************************
	$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	
	//****************************************************************************************
	// Set PDO error mode to exception
	//****************************************************************************************
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//****************************************************************************************
	// Execute SQL statement to fetch categories
	//****************************************************************************************
	$stmt = $conn->query("SELECT * FROM classification");

	//****************************************************************************************
	// Initialize variable for error message
	//****************************************************************************************
	$error = "";

//****************************************************************************************
//* Print the HTML form and call for "admin-add-articles-action.php"
//****************************************************************************************

echo '

<form action="admin-vehicle-register-action.php" method="post" enctype="multipart/form-data">


 <div class="row">


<div class="row">
        <div class="form-group col-md-6">
            <label for="image">Image:</label>
            <input type="file" class="form-control" id="invImage" name="invImage" accept="image/*">
        </div>
    </div>
 
                            <div class="form-group col-md-6">
                                <label for="year">Year:</label>
                                <input type="text" class="form-control" id="invYear" name="invYear" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="make">Make:</label>
                                <input type="text" class="form-control" id="invMake" name="invMake" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="model">Model:</label>
                                <input type="text" class="form-control" id="invModel" name="invModel" required>
                            </div> 

                            <div class="form-group col-md-6">
                                <label for="price">Price:</label>
                                <input type="text" class="form-control" id="invPrice" name="invPrice" required>
                            </div>
                        </div>
                              

                              
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="miles">Miles:</label>
                                <input type="text" class="form-control" id="invMiles" name="invMiles" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="miles">MPG:</label>
                                <input type="text" class="form-control" id="invMpg" name="invMpg" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="stock">Stock:</label>
                                <input type="text" class="form-control" id="invStock" name="invStock" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="color">Color:</label>
                                <input type="text" class="form-control" id="invColor" name="invColor" required>
                            </div>






                    <label for="category" class="form-label">Category</label> 
                        <select class="form-select" id="invCategory" name="invCategory" required>';
                                //****************************************************************************************
                                // Output options for classification select
                                //****************************************************************************************
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    $category = $row['category'];
                                    $id = $row['id'];
                                    echo "<option value='$category'>$category</option>";
                                }
                            echo '
                        </select>

                            <label for="description">Description:</label>
                            <textarea type="text" class="form-control" id="invDescription" name="invDescription"></textarea>
                    <br>
                    <center>
                        <button type="submit" class="btn" style="background-color:#a41003; color:white;">Add Vehicle</button>
                        <a href="admin-vehicle-list.php"><button type="button" class="btn" style="background-color:#a41003; color:white;">Cancel</button></a>
                    </center>
                </form>



                        ';


} catch(PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}
?>
