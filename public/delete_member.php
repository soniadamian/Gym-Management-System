<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['member_id'])) {
    $memberId = $_POST['member_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM members WHERE id = ?");
        $stmt->execute([$memberId]);

        header("Location: members.php?deleted=1");
        exit;
    } catch (PDOException $e) {
        die("Error deleting member: " . $e->getMessage());
    }
} else {
    header("Location: members.php");
    exit;
}
