<?php
include("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $customerName = $_POST['customer_name'];
    $feedback = $_POST['feedback'];
    $rating = $_POST['rating'];
    $sortOrder = $_POST['sort_order'];
   
    // Handle the file upload
    $targetDir = "../uploadedFiles/Testimonials/";
    $customerImageUrl = "";
    
    if (isset($_FILES["customer_image"]) && $_FILES["customer_image"]["error"] == 0) {
        $targetFile = $targetDir . basename($_FILES["customer_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["customer_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        
        // Check file size (optional, set to 5MB in this example)
        if ($_FILES["customer_image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        
        // Allow certain file formats
        $allowedExtensions = ['jpg', 'png', 'jpeg', 'gif'];
        if (!in_array($imageFileType, $allowedExtensions)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Try to upload file
            if (move_uploaded_file($_FILES["customer_image"]["tmp_name"], $targetFile)) {
                $customerImageUrl = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    
    // Insert into database
    $sql = "INSERT INTO testimonials (customer_name, feedback, rating, customer_image_url, sort_order) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $customerName, $feedback, $rating, $customerImageUrl, $sortOrder);
    
    if ($stmt->execute()) {
        echo "New testimonial added successfully.";
        header("Location: ./Testimonials.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>