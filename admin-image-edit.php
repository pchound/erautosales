<?php
include("admin-session.php");
?>
    <h5 style="color:white;">Want to change the main image? Dimensions of 2560 x 1111 are recommended.</h5>
    
    <form action="admin-image-edit-action.php" method="POST" enctype="multipart/form-data" id="image-form">
        <label for="mainImage">Upload New Image:</label>
        <input type="file" id="mainImage" name="mainImage" accept="image/*" required>
        <button type="submit">Upload</button>
    </form>
    <a href='admin-other.php'>Back</a>
</body>
</html>
