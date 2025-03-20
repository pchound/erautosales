<?php
include("admin-session.php");
?>
<br><br><br>
<h1>Admin Controls</h1>

<h4 style="color:white;">- Welcome Admin! -</h4>



<div class="container mt-5">

<div class="row">
    <div class='col-md-3 mb-3'>
        <div class='card'>
            <div class='card-body'>
                
                <h5 class='card-title'>
                    User Management
                </h5>
                <center>
                    <a href="admin-user-list.php"><button type="button" class="btn btn-outline-warning">Start</button></a> 
                </center>
            </div>
        </div>
    </div>


    <div class='col-md-3 mb-3'>
        <div class='card'>
            <div class='card-body'>
                
                <h5 class='card-title'>
                    Vehicle Management
                </h5>
                <center>
                    <a href="admin-vehicle-list.php"><button type="button" class="btn btn-outline-warning">Start</button></a> 
                </center>
            </div>
        </div>
    </div>

    <div class='col-md-3 mb-3'>
        <div class='card'>
            <div class='card-body'>
                
                <h5 class='card-title'>
                    Other Options
                </h5>
                <center>
                    <a href="admin-other.php"><button type="button" class="btn btn-outline-warning">Start</button></a> 
                </center>
            </div>
        </div>
    </div>

    <div class='col-md-3 mb-3'>
        <div class='card'>
            <div class='card-body'>
                
                <h5 class='card-title'>
                    Log Out
                </h5>
                <center>
                    <a href="logout.php"><button type="button" class="btn btn-outline-warning">Start</button></a> 
                </center>
            </div>
        </div>
    </div>

</div>

<?php
include("footer.php");
?>