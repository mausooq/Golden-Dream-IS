<?php
// Include the configuration file
require 'config.php';

// Connect to the database using the config function
$pdo = connectToDatabase();

// Function to add a new FAQ
function addFAQ($pdo, $question, $answer) {
    $stmt = $pdo->prepare("INSERT INTO faqs (question, answer) VALUES (?, ?)");
    return $stmt->execute([$question, $answer]);
}

// Function to fetch all FAQs
function fetchFAQs($pdo) {
    $stmt = $pdo->query("SELECT * FROM faqs");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Handle form submission for adding new FAQ
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    // Insert new FAQ
    if (addFAQ($pdo, $question, $answer)) {
        $message = "<strong>FAQ added successfully!</strong>";
    } else {
        $message = "<strong>Failed to add FAQ.</strong>";
    }
}

// Fetch all FAQs
$faqs = fetchFAQs($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Manage FAQs</h2>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST" class="mb-3">
            <div class="form-group">
                <label for="question">Question</label>
                <textarea name="question" id="question" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="answer">Answer</label>
                <textarea name="answer" id="answer" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add FAQ</button>
        </form>

        <h3>Existing FAQs</h3>
        <ul class="list-group">
            <?php foreach ($faqs as $faq): ?>
                <li class="list-group-item">
                    <strong>Question:</strong> <?php echo htmlspecialchars($faq['question']); ?><br>
                    <strong>Answer:</strong> <?php echo htmlspecialchars($faq['answer']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
