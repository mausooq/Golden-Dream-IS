<!-- insert_Faqs.php -->
<?php
include("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $question = $_POST['faq_question']; // Changed variable name to 'question'
    $answer = $_POST['faq_answer'];
    $sortOrder = $_POST['sort_order'];

    // Insert the FAQ into the database with correct column names
    $sql = "INSERT INTO faqs (question, answer, sort_order) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $question, $answer, $sortOrder); // ssi: string, string, int

    if ($stmt->execute()) {
        echo "New FAQ added successfully.";
        header("Location: ./Faqs.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
