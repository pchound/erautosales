<?php
include("admin-session.php");
?>


<div class="container"><br>
    <h2 style="color:white;">Manage Vehicles</h2>
    <table id="articlesTable" class="display table">
        <thead>
        <tr style="background-color:rgb(236, 174, 17);">
            <th>Image</th>
            <th>Make</th>
            <th>Model</th>
            <th>Year</th>
            <th>Description</th>
            <th>Price</th>
            <th>Miles</th>
            <th>MPG</th>
            <th>Stock</th>
            <th>Color</th>
            <th>Classification</th>
            <th>Options</th>
            
        </tr>
        </thead>
        <tbody>
        <?php
//****************************************************************************************
//* Database configuration
//****************************************************************************************
include("connection.php");

//****************************************************************************************
//* Via try connect to database and loop through categories and articles
//****************************************************************************************
        try {
            $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Fetch all vehicles
            $stmt = $pdo->prepare("SELECT * FROM inventory");
            $stmt->execute();
            $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
//****************************************************************************************
// Display users
//****************************************************************************************
            foreach ($vehicles as $vehicle) {
                $uid = htmlspecialchars($vehicle['invId']);
                echo "<tr>";
                    echo "<td><img src='";
                    echo  htmlspecialchars($vehicle['invThumbnail']);
                    echo "'height ='95' width='120'</td>";

                    echo "<td>" . htmlspecialchars($vehicle['invMake']) . "</td>";
                    echo "<td>" . htmlspecialchars($vehicle['invModel']) . "</td>";
                    echo "<td>" . htmlspecialchars($vehicle['invYear']) . "</td>";
                    echo "<td>" . htmlspecialchars($vehicle['invDescription']) . "</td>";
                    echo "<td>" . '$' . htmlspecialchars($vehicle['invPrice']) . "</td>";
                    echo "<td>" . htmlspecialchars($vehicle['invMiles']) . "</td>";
                    echo "<td>" . htmlspecialchars($vehicle['invMpg']) . "</td>";
                    echo "<td>" . htmlspecialchars($vehicle['invStock']) . "</td>";
                    echo "<td>" . htmlspecialchars($vehicle['invColor']) . "</td>";
                    echo "<td>" . htmlspecialchars($vehicle['invCategory']) . "</td>";
                
                    echo "<td>";
                        echo "<a href='admin-vehicle-edit.php?idd=$uid'><button type='button' class='row-btn'>Edit</button></a>&nbsp;";
                        echo "<a href='admin-vehicle-delete.php?idd=$uid'><button type='button' class='row-btn'>Delete</button></a>&nbsp;";
                    echo "</td>";
                echo "</tr>";
            }

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        ?>
        </tbody>
    </table>
    <center>
        <a href="admin-vehicle-register.php"><button type="button" class="btn btn-outline-warning">Add Vehicle</button></a>
        <a href="admin-dashboard.php"><button type="button" class="btn btn-outline-warning">Cancel</button></a>
    </center>
</div>

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.print.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.colVis.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready( function () {
        $('#articlesTable').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "dom": 'Bfrtip',
            "buttons": [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "columnDefs": [
                { "width": "10%", "targets": 0 }, // Image
                { "width": "10%", "targets": 1 }, // Make
                { "width": "10%", "targets": 0 }, // Model
                { "width": "10%", "targets": 1 }, // Description
                { "width": "10%", "targets": 0 }, // Price
                { "width": "10%", "targets": 1 }, // Miles
                { "width": "10%", "targets": 1 }, // MPG
                { "width": "10%", "targets": 1 }, // Stock
                { "width": "10%", "targets": 1 }, // Color
                { "width": "10%", "targets": 1 }, // Classification
                { "width": "10%", "targets": 1 }, // Options
            ]
        });
    });
</script>

</body>
</html>


