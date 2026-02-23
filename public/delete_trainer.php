<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM trainers WHERE id = ?");
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        die("Error deleting trainer: " . $e->getMessage());
    }
}

header("Location: trainers.php");
exit;
