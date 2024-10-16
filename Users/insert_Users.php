<!-- insert_User.php -->
<?php
include("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    // Insert the user into the database
    $sql = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $fullname, $email, $password); // sss: string, string, string

    if ($stmt->execute()) {
        echo "New user added successfully.";
        header("Location: ./Users.php"); // Redirect to Users.php or appropriate page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
