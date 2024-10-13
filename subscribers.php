<?php
// Include the configuration file
require 'config.php';

// Connect to the database using the config function
$pdo = connectToDatabase();

// Function to add a new subscriber
function addSubscriber($pdo, $email) {
    $stmt = $pdo->prepare("INSERT INTO subscribers (email) VALUES (?)");
    return $stmt->execute([$email]);
}

// Function to fetch all subscribers
function fetchSubscribers($pdo) {
    $stmt = $pdo->query("SELECT * FROM subscribers");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Handle form submission for adding new subscriber
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Insert new subscriber
    if (addSubscriber($pdo, $email)) {
        $message = "<strong>Subscriber added successfully!</strong>";
    } else {
        $message = "<strong>Failed to add subscriber.</strong>";
    }
}

// Fetch all subscribers
$subscribers = fetchSubscribers($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribers Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Manage Subscribers</h2>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST" class="mb-3">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Subscriber</button>
        </form>

        <h3>Existing Subscribers</h3>
        <ul class="list-group">
            <?php foreach ($subscribers as $subscriber): ?>
                <li class="list-group-item">
                    <strong>Email:</strong> <?php echo htmlspecialchars($subscriber['email']); ?><br>
                    <strong>Subscribed At:</strong> <?php echo $subscriber['subscribed_at']; ?><br>
                    <strong>Status:</strong> <?php echo $subscriber['status']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
