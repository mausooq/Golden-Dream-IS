<?php
// Include the configuration file
require 'config.php';

// Connect to the database using the config function
$pdo = connectToDatabase();

// Function to add a new pop-up
function addPopup($pdo, $popupImageUrl, $title, $linkUrl) {
    $stmt = $pdo->prepare("INSERT INTO popups (popup_image_url, title, link_url) VALUES (?, ?, ?)");
    return $stmt->execute([$popupImageUrl, $title, $linkUrl]);
}

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $popupImageUrl = $_POST['popup_image_url'];
    $title = $_POST['title'];
    $linkUrl = $_POST['link_url'];

    // Insert new pop-up
    if (addPopup($pdo, $popupImageUrl, $title, $linkUrl)) {
        $message = "<strong>Pop-up added successfully!</strong>";
    } else {
        $message = "<strong>Failed to add pop-up.</strong>";
    }
}

// Fetch all pop-ups
$stmt = $pdo->query("SELECT * FROM popups ORDER BY created_at ASC");
$popups = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pop-ups</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Pop-ups</h1>

        <!-- Display message -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-info">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <!-- Form to add a new pop-up -->
        <form method="POST" action="popups.php" class="mb-4">
            <div class="form-group">
                <label for="popup_image_url">Pop-up Image URL</label>
                <input type="text" class="form-control" id="popup_image_url" name="popup_image_url" required>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="link_url">Link URL</label>
                <input type="url" class="form-control" id="link_url" name="link_url" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Pop-up</button>
        </form>

        <!-- Table to display pop-ups -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image URL</th>
                    <th>Title</th>
                    <th>Link URL</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($popups as $popup): ?>
                    <tr>
                        <td><?= htmlspecialchars($popup['popup_id']) ?></td>
                        <td><img src="<?= htmlspecialchars($popup['popup_image_url']) ?>" alt="Pop-up Image" style="width: 50px; height: 50px;"></td>
                        <td><?= htmlspecialchars($popup['title']) ?></td>
                        <td><a href="<?= htmlspecialchars($popup['link_url']) ?>" target="_blank"><?= htmlspecialchars($popup['link_url']) ?></a></td>
                        <td><?= htmlspecialchars($popup['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
