<?php
// Include the configuration file
require 'config.php';

// Connect to the database using the config function
$pdo = connectToDatabase();

// Function to add a new collection
function addCollection($pdo, $name, $imageUrl, $sortOrder) {
    $stmt = $pdo->prepare("INSERT INTO collections (collection_name, collection_image_url, sort_order) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $imageUrl, $sortOrder]);
}

// Function to fetch all collections
function fetchCollections($pdo) {
    $stmt = $pdo->query("SELECT * FROM collections");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to add a new item to a collection
function addCollectionItem($pdo, $collectionId, $name, $imageUrl, $description, $originalPrice, $sellingPrice, $sortOrder) {
    $stmt = $pdo->prepare("INSERT INTO collection_items (collection_id, item_name, item_image_url, item_description, original_price, selling_price, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$collectionId, $name, $imageUrl, $description, $originalPrice, $sellingPrice, $sortOrder]);
}

// Function to fetch items for a specific collection
function fetchCollectionItems($pdo, $collectionId) {
    $stmt = $pdo->prepare("SELECT * FROM collection_items WHERE collection_id = ?");
    $stmt->execute([$collectionId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Handle form submission for adding new collection
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_collection'])) {
    $collectionName = $_POST['collection_name'];
    $collectionImageUrl = $_POST['collection_image_url'];
    $sortOrder = $_POST['sort_order'];

    // Insert new collection
    if (addCollection($pdo, $collectionName, $collectionImageUrl, $sortOrder)) {
        $message = "<strong>Collection added successfully!</strong>";
    } else {
        $message = "<strong>Failed to add collection.</strong>";
    }
}

// Handle form submission for adding new item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    $collectionId = $_POST['collection_id'];
    $itemName = $_POST['item_name'];
    $itemImageUrl = $_POST['item_image_url'];
    $itemDescription = $_POST['item_description'];
    $originalPrice = $_POST['original_price'];
    $sellingPrice = $_POST['selling_price'];
    $sortOrder = $_POST['sort_order'];

    // Insert new item
    if (addCollectionItem($pdo, $collectionId, $itemName, $itemImageUrl, $itemDescription, $originalPrice, $sellingPrice, $sortOrder)) {
        $message = "<strong>Item added successfully!</strong>";
    } else {
        $message = "<strong>Failed to add item.</strong>";
    }
}

// Fetch all collections
$collections = fetchCollections($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collections Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Manage Collections</h2>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <h4>Add New Collection</h4>
        <form method="POST" class="mb-3">
            <div class="form-group">
                <label for="collection_name">Collection Name</label>
                <input type="text" name="collection_name" id="collection_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="collection_image_url">Image URL</label>
                <input type="text" name="collection_image_url" id="collection_image_url" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" name="sort_order" id="sort_order" class="form-control" required>
            </div>
            <button type="submit" name="add_collection" class="btn btn-primary">Add Collection</button>
        </form>

        <h3>Existing Collections</h3>
        <ul class="list-group mb-4">
            <?php foreach ($collections as $collection): ?>
                <li class="list-group-item">
                    <strong>Collection Name:</strong> <?php echo htmlspecialchars($collection['collection_name']); ?><br>
                    <strong>Image URL:</strong> <?php echo htmlspecialchars($collection['collection_image_url']); ?><br>
                    <strong>Sort Order:</strong> <?php echo $collection['sort_order']; ?><br>
                    <strong>Items:</strong>
                    <ul>
                        <?php
                        $items = fetchCollectionItems($pdo, $collection['collection_id']);
                        foreach ($items as $item): ?>
                            <li><?php echo htmlspecialchars($item['item_name']); ?> - <?php echo htmlspecialchars($item['selling_price']); ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <h5>Add New Item to this Collection</h5>
                    <form method="POST" class="mb-3">
                        <input type="hidden" name="collection_id" value="<?php echo $collection['collection_id']; ?>">
                        <div class="form-group">
                            <label for="item_name">Item Name</label>
                            <input type="text" name="item_name" id="item_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="item_image_url">Item Image URL</label>
                            <input type="text" name="item_image_url" id="item_image_url" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="item_description">Item Description</label>
                            <textarea name="item_description" id="item_description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="original_price">Original Price</label>
                            <input type="number" step="0.01" name="original_price" id="original_price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="selling_price">Selling Price</label>
                            <input type="number" step="0.01" name="selling_price" id="selling_price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="sort_order">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" required>
                        </div>
                        <button type="submit" name="add_item" class="btn btn-success">Add Item</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
