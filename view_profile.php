<?php
session_start();
require_once '../config/db.php';
include('../includes/header.php');


if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit;
}

$member_id = $_SESSION['member_id'];
$success = $error = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);

    try {
        $stmt = $pdo->prepare("UPDATE members SET first_name = ?, last_name = ?, phone = ? WHERE id = ?");
        $stmt->execute([$first_name, $last_name, $phone, $member_id]);
        $success = "Profile updated successfully.";
    } catch (PDOException $e) {
        $error = "Update failed: " . $e->getMessage();
    }
}


$stmt = $pdo->prepare("SELECT first_name, last_name, email, phone FROM members WHERE id = ?");
$stmt->execute([$member_id]);
$member = $stmt->fetch();
?>

<div class="container mt-4">
    <h2>My Profile</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>First Name:</label>
            <input type="text" name="first_name" value="<?= htmlspecialchars($member['first_name']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Last Name:</label>
            <input type="text" name="last_name" value="<?= htmlspecialchars($member['last_name']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email (read-only):</label>
            <input type="email" value="<?= htmlspecialchars($member['email']) ?>" class="form-control" disabled>
        </div>
        <div class="mb-3">
            <label>Phone:</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($member['phone']) ?>" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
