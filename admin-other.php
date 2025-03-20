<?php
include("admin-session.php");
?>
<br><br>

<a href="admin-dashboard.php"><button type="button" class="btn btn-outline-warning">Back</button></a> 

<h4 style="color:white;">Other options</h4>

<div class="container mt-5">
<div class="row">

    <div class='col-md-3 mb-3'>
        <div class='card'>
            <div class='card-body'>
                
                <h5 class='card-title'>
                    Main Image
                </h5>
                <center>
                    <a href="admin-image-edit.php"><button type="button" class="btn btn-outline-warning">Start</button></a> 
                </center>
            </div>
        </div>
    </div>


    <div class='col-md-3 mb-3'>
        <div class='card'>
            <div class='card-body'>
                
                <h5 class='card-title'>
                    Contact
                </h5>
                <center>
                    <a href="admin-other-contact.php"><button type="button" class="btn btn-outline-warning">Start</button></a> 
                </center>
            </div>
        </div>
    </div>



    <div class='col-md-3 mb-3'>
        <div class='card'>
            <div class='card-body'>
                
                <h5 class='card-title'>
                    About
                </h5>
                <center>
                    <a href="admin-other-about.php"><button type="button" class="btn btn-outline-warning">Start</button></a> 
                </center>
            </div>
        </div>
    </div>


    <div class='col-md-3 mb-3'>
        <div class='card'>
            <div class='card-body'>
                
                <h5 class='card-title'>
                    Logout
                </h5>
                <center>
                    <a href="logout.php"><button type="button" class="btn btn-outline-warning">Logout</button></a> 
                </center>
            </div>
        </div>
    </div>



</div>
</div>

<?php
include("footer.php");
?>