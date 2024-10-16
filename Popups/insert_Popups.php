<!-- insert_Popups.php -->
<?php
include("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $popupImageUrl = $_POST['popup_image_url'];
    $title = $_POST['title'];
    $linkUrl = $_POST['link_url'];

    // Insert the popup into the database
    $sql = "INSERT INTO popups (popup_image_url, title, link_url) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $popupImageUrl, $title, $linkUrl); // sss: string, string, string

    if ($stmt->execute()) {
        echo "New popup added successfully.";
        header("Location: ./Add-Popups.php"); // Redirect back to the add popup page
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
