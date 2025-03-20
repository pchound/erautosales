<?php
include("admin-session.php");
?>


<br>

<div class="container mt-5">
    <h2 style="color:white; text-align:center;">Edit User</h2><br>
    <?php

//****************************************************************************************
//* Database configuration
//****************************************************************************************
include("connection.php");

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve user data based on ID
        if (isset($_GET['idd']) && is_numeric($_GET['idd'])) {
            $user_id = intval($_GET['idd']);
            $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Display edit form with user data
                ?>

                <form action="admin-user-edit-action.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                    <div class="row justify-content-center">
                            <div class="form-group col-md-6">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>

                        </div>
                    <br>
                    <center>
                        <button type="submit" class="btn btn-outline-warning">Update User</button>
                        <a href="admin-user-list.php"><button type="button" class="btn btn-outline-warning">Cancel</button></a>
                    </center>
                </form>

                <?php
            } else {
                echo "User not found.";
            }
        } else {
            echo "Invalid user ID.";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>
</div>
</body>
</html>
