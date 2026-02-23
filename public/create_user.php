<?php
require_once '../config/db.php';
include('../includes/header.php');


$username = 'admin';
$password = 'admin123'; 

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hashedPassword]);
    echo "User 'admin' created successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<?php include('../includes/footer.php'); ?>
