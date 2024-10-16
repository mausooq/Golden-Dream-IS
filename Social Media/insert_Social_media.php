<?php
include("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $platformName = $_POST['platform_name'];
    $linkUrl = $_POST['link_url'];
    $sortOrder = $_POST['sort_order'];
    
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO social_media_links (platform_name, link_url, sort_order) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $platformName, $linkUrl, $sortOrder);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New social media link added successfully.";
        // Redirect to the social media links page
        header("Location: ./Social_media.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>