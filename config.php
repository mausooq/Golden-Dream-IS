


<?php
// config.php
$host = 'localhost';
$db = 'GD'; // Replace with your database name
$user = 'root';     // Replace with your database username
$pass = '';     // Replace with your database password

function connectToDatabase() {
    global $host, $db, $user, $pass;
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }
}
?>
