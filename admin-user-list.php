<?php
include("admin-session.php");
?>


<body>
<div class="container"><br>
    <h2 style="color:white;">Manage Users</h2>
    <table id="articlesTable" class="display table">
        <thead>
        <tr style="background-color:rgb(236, 174, 17);">
            <th>Email</th>
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

            // Fetch all users
            $stmt = $pdo->prepare("SELECT * FROM user");
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
//****************************************************************************************
// Display users
//****************************************************************************************
            foreach ($users as $user) {
                $uid = htmlspecialchars($user['id']);
                echo "<tr>";
                    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                
                    echo "<td>";
                        echo "<a href='admin-user-edit.php?idd=$uid'><button type='button' class='row-btn'>Edit</button></a>&nbsp;";
                        echo "<a href='admin-user-delete.php?idd=$uid'><button type='button' class='row-btn'>Delete</button></a>&nbsp;";
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
        <a href="admin-user-register.php"><button type="button" class="btn btn-outline-warning">Add User</button></a>
        <a href="admin-dashboard.php"><button type="button" class="btn btn-outline-warning" class="btn btn-primary">Cancel</button></a>
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
                { "width": "50%", "targets": 0 }, // Email
                { "width": "50%", "targets": 1 }, // Options

            ]
        });
    });
</script>

</body>
</html>


