<!-- insert_Subscribers.php -->
<?php
include("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];

    // Insert the subscriber into the database
    $sql = "INSERT INTO subscribers (email) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // s: string

    if ($stmt->execute()) {
        echo "New subscriber added successfully.";
        header("Location: ./Subscribers.php"); // Redirect to Subscribers.php or appropriate page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
