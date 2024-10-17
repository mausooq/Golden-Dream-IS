<?php
// Include database connection
include '../config.php';

// Check if item_id is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Item ID is required");
}

$item_id = $_GET['id'];

// Fetch the item details
$sql = "SELECT ci.*, c.collection_name FROM collection_items ci
        JOIN collections c ON ci.collection_id = c.collection_id
        WHERE ci.item_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $item_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Item not found");
}

$item = $result->fetch_assoc();

// Fetch all collections for the dropdown
$collections_sql = "SELECT collection_id, collection_name FROM collections ORDER BY collection_name";
$collections_result = $conn->query($collections_sql);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['item_name'];
    $collection_id = $_POST['collection_id'];
    $item_description = $_POST['item_description'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $sort_order = $_POST['sort_order'];
    
    // Check if a new image is uploaded
    if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../uploadedFiles/CollectionItems/";
        $target_file = $target_dir . basename($_FILES["item_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Allow certain file formats
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        if (in_array($imageFileType, $allowed_extensions)) {
            if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file)) {
                $item_image_url = $target_file;
            } else {
                die("Sorry, there was an error uploading your file.");
            }
        } else {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }
    } else {
        // Keep the existing image URL if no new image is uploaded
        $item_image_url = $item['item_image_url'];
    }
    
    // Update the item in the database
    $update_sql = "UPDATE collection_items SET 
                   collection_id = ?, 
                   item_name = ?, 
                   item_image_url = ?, 
                   item_description = ?, 
                   original_price = ?, 
                   selling_price = ?, 
                   sort_order = ? 
                   WHERE item_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("isssddii", $collection_id, $item_name, $item_image_url, $item_description, $original_price, $selling_price, $sort_order, $item_id);
    
    if ($update_stmt->execute()) {
        // Redirect to the collection items list page after successful update
        header("Location: CollectionItems.php");
        exit();
    } else {
        die("Error updating item: " . $conn->error);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Collection Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <!-- Dashboard -->
    <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
        <!-- Vertical Navbar -->
        <nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light bg-white border-bottom border-bottom-lg-0 border-end-lg" id="navbarVertical">
            <!-- Navbar content (same as in previous examples) -->
        </nav>
        <!-- Main content -->
        <div class="h-screen flex-grow-1 overflow-y-lg-auto">
            <!-- Header -->
            <header class="bg-surface-primary border-bottom pt-6">
                <div class="container-fluid">
                    <div class="mb-npx">
                        <div class="row align-items-center">
                            <div class="col-sm-6 col-12 mb-4 mb-sm-0">
                                <!-- Title -->
                                <h1 class="h2 mb-0 ls-tight">Edit Collection Item</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Main -->
            <main class="py-6 bg-surface-secondary">
                <div class="container-fluid">
                    <div class="card shadow border-0 mb-7">
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="itemName" class="form-label">Item Name</label>
                                    <input type="text" class="form-control" id="itemName" name="item_name" value="<?php echo htmlspecialchars($item['item_name']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="collectionId" class="form-label">Collection</label>
                                    <select class="form-control" id="collectionId" name="collection_id" required>
                                        <?php
                                        while ($collection = $collections_result->fetch_assoc()) {
                                            $selected = ($collection['collection_id'] == $item['collection_id']) ? 'selected' : '';
                                            echo "<option value='" . $collection['collection_id'] . "' $selected>" . htmlspecialchars($collection['collection_name']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="itemImage" class="form-label">Item Image</label>
                                    <input type="file" class="form-control" id="itemImage" name="item_image" accept="image/*">
                                    <small class="form-text text-muted">Leave empty to keep the current image.</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="itemDescription" class="form-label">Item Description</label>
                                    <textarea class="form-control" id="itemDescription" name="item_description" rows="3"><?php echo htmlspecialchars($item['item_description']); ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="originalPrice" class="form-label">Original Price</label>
                                    <input type="number" step="0.01" class="form-control" id="originalPrice" name="original_price" value="<?php echo htmlspecialchars($item['original_price']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="sellingPrice" class="form-label">Selling Price</label>
                                    <input type="number" step="0.01" class="form-control" id="sellingPrice" name="selling_price" value="<?php echo htmlspecialchars($item['selling_price']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="sortOrder" class="form-label">Sort Order</label>
                                    <input type="number" class="form-control" id="sortOrder" name="sort_order" value="<?php echo htmlspecialchars($item['sort_order']); ?>" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Update Item</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>