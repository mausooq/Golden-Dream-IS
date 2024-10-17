<!-- insert_trendingCollections.php -->
<?php
include("../config.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $collectionName = $_POST['collection_name'];
    $sortOrder = $_POST['sort_order'];
    
    // Handle the file upload
    $targetDir = "../uploadedFiles/trendingCollections/";
    $targetFile = $targetDir . basename($_FILES["collection_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["collection_image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (optional, set to 5MB in this example)
    if ($_FILES["collection_image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Try to upload file
        if (move_uploaded_file($_FILES["collection_image"]["tmp_name"], $targetFile)) {
            // Insert into database
            $sql = "INSERT INTO trending_collections (collection_name, collection_image_url, sort_order) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $collectionName, $targetFile, $sortOrder); // ssi: string, string, int

            if ($stmt->execute()) {
                echo "New collection added successfully.";
                header("Location: ./TrendingCollections.php");
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>
