<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("No subscription ID provided.");
}

try {
    $stmt = $pdo->prepare("DELETE FROM subscriptions WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: subscriptions.php");
    exit;
} catch (PDOException $e) {
    die("Error deleting subscription: " . $e->getMessage());
}
