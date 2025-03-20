<?php
// Include database connection
include("connection.php");

try {
    // PDO Connection
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Validate required fields
    $requiredFields = ['invId', 'invYear', 'invMake', 'invModel', 'invDescription', 'invPrice', 'invMiles', 'invMpg', 'invStock', 'invColor', 'invCategory'];
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            die("Error: Missing or empty value for $field");
        }
    }

    // Extract form data
    $invId = $_POST['invId'];
    $invYear = $_POST['invYear'];
    $invMake = $_POST['invMake'];
    $invModel = $_POST['invModel'];
    $invDescription = $_POST['invDescription'];
    $invPrice = $_POST['invPrice'];
    $invMiles = $_POST['invMiles'];
    $invMpg = $_POST['invMpg'];
    $invStock = $_POST['invStock'];
    $invColor = $_POST['invColor'];
    $invCategory = $_POST['invCategory'];

    // Initialize variables for image paths
    $invImage = null;
    $invThumbnail = null;

    // Retrieve current image paths from the database
    $stmt = $pdo->prepare("SELECT invImage, invThumbnail FROM inventory WHERE invId = :invId");
    $stmt->bindParam(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $currentImages = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$currentImages) {
        die("Error: Vehicle not found.");
    }

    $currentImagePath = $currentImages['invImage'];
    $currentThumbnailPath = $currentImages['invThumbnail'];

    // Check if a new image is uploaded
    if (isset($_FILES['invImage']) && $_FILES['invImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "er-img/vehicles/"; // Directory for storing images
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
        }

        $imageFileType = strtolower(pathinfo($_FILES['invImage']['name'], PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate file type
        if (!in_array($imageFileType, $allowedTypes)) {
            die("Error: Invalid file type. Allowed types are JPG, JPEG, PNG, and GIF.");
        }

        // Generate unique file names for the image and thumbnail
        $imageName = uniqid('img_') . '.' . $imageFileType;
        $thumbName = uniqid('thumb_') . '.' . $imageFileType;

        $imagePath = $uploadDir . $imageName;
        $thumbPath = $uploadDir . $thumbName;

        // Delete old images if they exist
        if (!empty($currentImagePath) && file_exists($currentImagePath)) {
            unlink($currentImagePath); // Delete old image
        }
        if (!empty($currentThumbnailPath) && file_exists($currentThumbnailPath)) {
            unlink($currentThumbnailPath); // Delete old thumbnail
        }

        // Move uploaded image to the upload directory
        if (!move_uploaded_file($_FILES['invImage']['tmp_name'], $imagePath)) {
            die("Error: Failed to upload the image.");
        }

        // Create a thumbnail
        if (!createThumbnail($imagePath, $thumbPath, 400, 400)) { // Thumbnail size: 400x400
            die("Error: Failed to create a thumbnail.");
        }

        // Update image paths
        $invImage = $imagePath;
        $invThumbnail = $thumbPath;
    } else {
        // Keep the current paths if no new image is uploaded
        $invImage = $currentImagePath;
        $invThumbnail = $currentThumbnailPath;
    }

    // Update database record
    $stmt = $pdo->prepare("UPDATE inventory SET 
        invYear = :invYear,
        invMake = :invMake,
        invModel = :invModel,
        invDescription = :invDescription,
        invImage = :invImage,
        invThumbnail = :invThumbnail,
        invPrice = :invPrice,
        invMiles = :invMiles,
        invMpg = :invMpg,
        invStock = :invStock,
        invColor = :invColor,
        invCategory = :invCategory
        WHERE invId = :invId");

    $stmt->bindParam(':invYear', $invYear);
    $stmt->bindParam(':invMake', $invMake);
    $stmt->bindParam(':invModel', $invModel);
    $stmt->bindParam(':invDescription', $invDescription);
    $stmt->bindParam(':invImage', $invImage);
    $stmt->bindParam(':invThumbnail', $invThumbnail);
    $stmt->bindParam(':invPrice', $invPrice);
    $stmt->bindParam(':invMiles', $invMiles);
    $stmt->bindParam(':invMpg', $invMpg);
    $stmt->bindParam(':invStock', $invStock);
    $stmt->bindParam(':invColor', $invColor);
    $stmt->bindParam(':invCategory', $invCategory);
    $stmt->bindParam(':invId', $invId);
    $stmt->execute();

    // Redirect with success message
    header("Location: admin-vehicle-list.php?status=success");
    exit();

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Function to create a thumbnail from the original image
function createThumbnail($sourcePath, $thumbPath, $thumbWidth, $thumbHeight) {
    list($width, $height, $type) = getimagesize($sourcePath);

    // Create an image resource based on the image type
    switch ($type) {
        case IMAGETYPE_JPEG:
            $srcImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $srcImage = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_GIF:
            $srcImage = imagecreatefromgif($sourcePath);
            break;
        default:
            return false;
    }

    // Calculate thumbnail dimensions while maintaining aspect ratio
    $ratio = $width / $height;
    if ($thumbWidth / $thumbHeight > $ratio) {
        $thumbWidth = $thumbHeight * $ratio;
    } else {
        $thumbHeight = $thumbWidth / $ratio;
    }

    // Create a blank thumbnail image
    $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);

    // Resize the original image onto the thumbnail
    imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);

    // Save the thumbnail image
    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($thumbImage, $thumbPath, 90); // Quality: 90
            break;
        case IMAGETYPE_PNG:
            imagepng($thumbImage, $thumbPath);
            break;
        case IMAGETYPE_GIF:
            imagegif($thumbImage, $thumbPath);
            break;
    }

    // Free memory
    imagedestroy($srcImage);
    imagedestroy($thumbImage);

    return true;
}
?>
