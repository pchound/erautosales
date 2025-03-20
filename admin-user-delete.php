<?php
include("admin-session.php");
?>

<div class="container mt-5">
    <h2 style="color:white; text-align:center;">Delete User</h2><br>
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
        //****************************************************************************************
        // Retrieve user data based on ID
        //****************************************************************************************
        $user_id = $_GET['idd']; // Assuming you're passing user ID through query parameter
        $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        $use = $stmt->fetch(PDO::FETCH_ASSOC);

//****************************************************************************************
//* Print the HTML form and call for "admin-user-delete-action.php"
//****************************************************************************************
        ?>
        <form action="admin-user-delete-action.php?id=<?php echo $use; ?>" method="GET">
            <input type="hidden" name="id" value="<?php echo $use['id']; ?>">
            <div class="row justify-content-center">
                <div class="form-group  col-md-6">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $use['email']; ?>" readonly>
                </div>
            </div>
   
<br><center><h4 style="color:white; text-align:center;">Caution: are you sure you want to delete this user??</h4></center><br>
            <br>
        <center>
        <center>
            <button type="submit" class="btn btn-outline-warning">Delete User</button> 

            <a href="admin-user-list.php"><button type="button" class="btn btn-outline-warning">Cancel</button></a></center>
        </center>
        </form>
        <?php
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>
</div>
</body>
</html>
