<?php
include("../config.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $collection_id = $_POST['collection_id'];
    $item_name = $_POST['item_name'];
    $item_description = $_POST['item_description'];
    $original_price = $_POST['original_price'];
    $selling_price = $_POST['selling_price'];
    $sort_order = $_POST['sort_order'];

    // Handle file upload
    $target_dir = "../uploadedFiles/CollectionItems/";
    $target_file = $target_dir . basename($_FILES["item_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["item_image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["item_image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // If everything is ok, try to upload file and insert data
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file)) {
            // Prepare an insert statement
            $sql = "INSERT INTO collection_items (collection_id, item_name, item_image_url, item_description, original_price, selling_price, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("isssddi", $collection_id, $item_name, $target_file, $item_description, $original_price, $selling_price, $sort_order);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Redirect to the collection items page with a success message
                    header("location: CollectionItems.php?message=Item added successfully");
                    exit();
                } else {
                    echo "Something went wrong. Please try again later.";
                }

                // Close statement
                $stmt->close();
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Close connection
    $conn->close();
} else {
    // If the form wasn't submitted, redirect to the add item page
    header("location: Add-CollectionItems.php");
    exit();
}
?>