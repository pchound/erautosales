<?php
// Database connection
include("connection.php");

try {
    // Initialize PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle the uploaded image and thumbnail
    $imagePath = null;
    $thumbPath = null;

    // Check if an ID is provided for an existing record
    if (isset($_POST['invId'])) {
        $invId = intval($_POST['invId']);

        // Fetch existing image and thumbnail paths
        $query = $pdo->prepare("SELECT invImage, invThumbnail FROM inventory WHERE id = :invId");
        $query->bindParam(':invId', $invId, PDO::PARAM_INT);
        $query->execute();
        $existingRecord = $query->fetch(PDO::FETCH_ASSOC);

        if ($existingRecord) {
            $existingImagePath = $existingRecord['invImage'];
            $existingThumbPath = $existingRecord['invThumbnail'];
        } else {
            die("Error: Record not found for the provided ID.");
        }
    }

    // Process new image upload
    if (isset($_FILES['invImage']) && $_FILES['invImage']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "er-img/vehicles/"; // Directory to store images
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); // Create directory if it doesn't exist
        }

        $imageFileType = strtolower(pathinfo($_FILES['invImage']['name'], PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate file type
        if (!in_array($imageFileType, $allowedTypes)) {
            die("Error: Invalid file type. Allowed types are JPG, JPEG, PNG, and GIF.");
        }

        // Generate unique file names
        $imageName = uniqid('img_') . '.' . $imageFileType;
        $thumbName = uniqid('thumb_') . '.' . $imageFileType;

        $imagePath = $targetDir . $imageName;
        $thumbPath = $targetDir . $thumbName;

        // Delete old images if they exist
        if (!empty($existingImagePath) && file_exists($existingImagePath)) {
            unlink($existingImagePath);
        }
        if (!empty($existingThumbPath) && file_exists($existingThumbPath)) {
            unlink($existingThumbPath);
        }

        // Move the uploaded file
        if (!move_uploaded_file($_FILES['invImage']['tmp_name'], $imagePath)) {
            die("Error: Failed to upload the image.");
        }

        // Create a thumbnail
        if (!createThumbnail($imagePath, $thumbPath, 400, 400)) { // Thumbnail size: 400x400
            die("Error: Failed to create a thumbnail.");
        }
    } else {
        // Retain old paths if no new image is uploaded
        $imagePath = $existingImagePath ?? null;
        $thumbPath = $existingThumbPath ?? null;
    }

    // Collect form data
    $invYear = $_POST['invYear'] ?? '';
    $invMake = $_POST['invMake'] ?? '';
    $invModel = $_POST['invModel'] ?? '';
    $invDescription = $_POST['invDescription'] ?? '';
    $invPrice = $_POST['invPrice'] ?? '';
    $invMiles = $_POST['invMiles'] ?? '';
    $invMpg = $_POST['invMpg'] ?? '';
    $invStock = $_POST['invStock'] ?? '';
    $invColor = $_POST['invColor'] ?? '';
    $invCategory = $_POST['invCategory'] ?? '';

    // Insert or update the record
    if (isset($invId)) {
        $stmt = $pdo->prepare("UPDATE inventory SET 
            invYear = :invYear,
            invMake = :invMake,
            invModel = :invModel,
            invDescription = :invDescription,
            invPrice = :invPrice,
            invMiles = :invMiles,
            invMpg = :invMpg,
            invStock = :invStock,
            invColor = :invColor,
            invImage = :invImage,
            invThumbnail = :invThumbnail,
            invCategory = :invCategory
            WHERE id = :invId");
        $stmt->bindParam(':invId', $invId, PDO::PARAM_INT);
    } else {
        $stmt = $pdo->prepare("INSERT INTO inventory (
            invYear, 
            invMake, 
            invModel, 
            invDescription, 
            invPrice, 
            invMiles, 
            invMpg, 
            invStock, 
            invColor,
            invImage,
            invThumbnail,
            invCategory
        ) VALUES (
            :invYear, 
            :invMake, 
            :invModel, 
            :invDescription, 
            :invPrice, 
            :invMiles, 
            :invMpg, 
            :invStock, 
            :invColor,
            :invImage,
            :invThumbnail,
            :invCategory
        )");
    }

    // Bind parameters
    $stmt->bindParam(':invYear', $invYear);
    $stmt->bindParam(':invMake', $invMake);
    $stmt->bindParam(':invModel', $invModel);
    $stmt->bindParam(':invDescription', $invDescription);
    $stmt->bindParam(':invPrice', $invPrice);
    $stmt->bindParam(':invMiles', $invMiles);
    $stmt->bindParam(':invMpg', $invMpg);
    $stmt->bindParam(':invStock', $invStock);
    $stmt->bindParam(':invColor', $invColor);
    $stmt->bindParam(':invImage', $imagePath);
    $stmt->bindParam(':invThumbnail', $thumbPath);
    $stmt->bindParam(':invCategory', $invCategory);
    $stmt->execute();

    // Redirect back to the list
    header("Location: admin-vehicle-list.php");
    exit();

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Function to create a thumbnail
function createThumbnail($sourcePath, $thumbPath, $thumbWidth, $thumbHeight) {
    list($width, $height, $type) = getimagesize($sourcePath);

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

    $thumbRatio = $width / $height;
    if ($thumbWidth / $thumbHeight > $thumbRatio) {
        $thumbWidth = $thumbHeight * $thumbRatio;
    } else {
        $thumbHeight = $thumbWidth / $thumbRatio;
    }

    $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
    imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);

    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($thumbImage, $thumbPath, 90);
            break;
        case IMAGETYPE_PNG:
            imagepng($thumbImage, $thumbPath);
            break;
        case IMAGETYPE_GIF:
            imagegif($thumbImage, $thumbPath);
            break;
    }

    imagedestroy($srcImage);
    imagedestroy($thumbImage);

    return true;
}
?>
