<?php
// Include the configuration file
require 'config.php';

// Connect to the database using the config function
$pdo = connectToDatabase();

// Function to add a new social media link
function addSocialMediaLink($pdo, $platformName, $linkUrl) {
    $stmt = $pdo->prepare("INSERT INTO social_media_links (platform_name, link_url) VALUES (?, ?)");
    return $stmt->execute([$platformName, $linkUrl]);
}

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $platformName = $_POST['platform_name'];
    $linkUrl = $_POST['link_url'];

    // Insert new social media link
    if (addSocialMediaLink($pdo, $platformName, $linkUrl)) {
        $message = "<strong>Social media link added successfully!</strong>";
    } else {
        $message = "<strong>Failed to add social media link.</strong>";
    }
}

// Fetch all social media links
$stmt = $pdo->query("SELECT * FROM social_media_links ORDER BY created_at ASC");
$socialMediaLinks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media Links</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Social Media Links</h1>

        <!-- Display message -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-info">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <!-- Form to add a new social media link -->
        <form method="POST" action="social_media.php" class="mb-4">
            <div class="form-group">
                <label for="platform_name">Platform Name</label>
                <input type="text" class="form-control" id="platform_name" name="platform_name" required>
            </div>
            <div class="form-group">
                <label for="link_url">Link URL</label>
                <input type="url" class="form-control" id="link_url" name="link_url" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Link</button>
        </form>

        <!-- Table to display social media links -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Platform Name</th>
                    <th>Link URL</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($socialMediaLinks as $link): ?>
                    <tr>
                        <td><?= htmlspecialchars($link['id']) ?></td>
                        <td><?= htmlspecialchars($link['platform_name']) ?></td>
                        <td><a href="<?= htmlspecialchars($link['link_url']) ?>" target="_blank"><?= htmlspecialchars($link['link_url']) ?></a></td>
                        <td><?= htmlspecialchars($link['created_at']) ?></td>
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
