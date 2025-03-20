
<?php
//****************************************************************************************
//*
//*       Name: register.php
//*       Author: Joseph Garner
//*       Date: 12/02/2024
//*       Version: 1.00
//*       Purpose: A form for the user to register themselves.
//*
//****************************************************************************************
?>





<div class="container mt-5">
	<h2>
		Register a new admin account. For new admins only! Visitors should not register accounts of any kind!
	</h2><br>
    <form action="admin-user-register-action.php" method="POST">
		<div class="row">
			<div class="form-group col-md-6">
				<label for="email">Email:</label> 
				<input type="email" class="form-control" id="email" name="email" required>
			</div>
		</div>
		
		<div class="row">
			<div class="form-group col-md-6">
				<label for="password">Password:</label> 
				<input type="password" class="form-control" id="password" name="password" required>
			</div>

		</div>
		<br><center><button type="submit" class="btn" style="background-color:#a41003;color:white;">Register</button>
		
		<a href="index.php"><button type="button" class="btn" style="background-color:#a41003;color:white;">Cancel</button></a></center>
	</form>

