<!-- Edit-TrendingCollections.php -->
<?php
// Include database connection
include '../config.php';

// Check if collection_id is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Collection ID is required");
}

$collection_id = $_GET['id'];

// Fetch the collection details
$sql = "SELECT * FROM trending_collections WHERE collection_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $collection_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Collection not found");
}

$collection = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $collection_name = $_POST['collection_name'];
    $sort_order = $_POST['sort_order'];
    
    // Check if a new image is uploaded
    if (isset($_FILES['collection_image']) && $_FILES['collection_image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../uploadedFiles/trendingCollections";
        $target_file = $target_dir . basename($_FILES["collection_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Allow certain file formats
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        if (in_array($imageFileType, $allowed_extensions)) {
            if (move_uploaded_file($_FILES["collection_image"]["tmp_name"], $target_file)) {
                $collection_image_url = $target_file;
            } else {
                die("Sorry, there was an error uploading your file.");
            }
        } else {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }
    } else {
        // Keep the existing image URL if no new image is uploaded
        $collection_image_url = $collection['collection_image_url'];
    }
    
    // Update the collection in the database
    $update_sql = "UPDATE trending_collections SET collection_name = ?, collection_image_url = ?, sort_order = ? WHERE collection_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssii", $collection_name, $collection_image_url, $sort_order, $collection_id);
    
    if ($update_stmt->execute()) {
        // Redirect to the trending collections list page after successful update
        header("Location: TrendingCollections.php");
        exit();
    } else {
        die("Error updating collection: " . $conn->error);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Trending Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <!-- Include the navigation code here -->

    <!-- Main content -->
    <div class="h-screen flex-grow-1 overflow-y-lg-auto">
        <!-- Header -->
        <header class="bg-surface-primary border-bottom pt-6">
            <div class="container-fluid">
                <div class="mb-npx">
                    <div class="row align-items-center">
                        <div class="col-sm-6 col-12 mb-4 mb-sm-0">
                            <!-- Title -->
                            <h1 class="h2 mb-0 ls-tight">Edit Trending Collection</h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main -->
        <div class="container">
            <div class="container mt-5">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="collectionName" class="form-label">Collection Name</label>
                        <input type="text" class="form-control" id="collectionName" name="collection_name" value="<?php echo htmlspecialchars($collection['collection_name']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="collectionImage" class="form-label">Collection Image</label>
                        <input type="file" class="form-control" id="collectionImage" name="collection_image" accept="image/*">
                        <small class="form-text text-muted">Leave empty to keep the current image.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sortOrder" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" id="sortOrder" name="sort_order" value="<?php echo htmlspecialchars($collection['sort_order']); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Collection</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>