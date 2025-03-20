<?php
include("header.php");
?>
<br>
<h1 class="text-center">Login</h1>
<p class="text-center">- For administrators only -</p>

  <div class="row">
    <div class="col-md-6 col-lg-4 mx-auto"> <!-- Makes the form narrower and centers it -->
      <form action="login-action.php" method="POST">
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <br>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <br>
        <div class="text-center">
          <button type="submit" class="btn btn-outline-warning">Login</button>
          <a href="index.php"><button type="button" class="btn btn-outline-warning">Cancel</button></a>
        </div>
      </form>
    </div>
  </div>

<br>
<?php
include("footer.php");
?>
