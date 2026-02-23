<?php
require_once '../includes/auth.php';
require_once '../config/db.php';
include('../includes/header.php');

$success = $error = "";
$id = $_GET['id'] ?? null;

if (!$id) {
    die("No subscription ID provided.");
}

$stmt = $pdo->prepare("SELECT * FROM subscriptions WHERE id = ?");
$stmt->execute([$id]);
$subscription = $stmt->fetch();

if (!$subscription) {
    die("Subscription not found.");
}

$members = $pdo->query("SELECT id, first_name, last_name FROM members")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = (int) $_POST['member_id'];
    $plan_name = trim($_POST['plan_name']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $price = (float) $_POST['price'];
    $status = $_POST['status'];

    if ($member_id && $plan_name && $start_date && $end_date && $price >= 0 && in_array($status, ['active', 'expired', 'cancelled'])) {
        try {
            $stmt = $pdo->prepare("UPDATE subscriptions SET member_id=?, plan_name=?, start_date=?, end_date=?, price=?, status=? WHERE id=?");
            $stmt->execute([$member_id, $plan_name, $start_date, $end_date, $price, $status, $id]);
            $success = "Subscription updated successfully.";
            // Refresh data
            $stmt = $pdo->prepare("SELECT * FROM subscriptions WHERE id = ?");
            $stmt->execute([$id]);
            $subscription = $stmt->fetch();
        } catch (PDOException $e) {
            $error = "Error updating subscription: " . $e->getMessage();
        }
    } else {
        $error = "Please complete all fields correctly.";
    }
}
?>

<div class="container mt-4">
    <h2>Edit Subscription</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Member:</label>
            <select name="member_id" class="form-control" required>
                <?php foreach ($members as $m): ?>
                    <option value="<?= $m['id'] ?>" <?= $m['id'] == $subscription['member_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($m['first_name'] . ' ' . $m['last_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Plan Name:</label>
            <input type="text" name="plan_name" class="form-control" value="<?= htmlspecialchars($subscription['plan_name']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Start Date:</label>
            <input type="date" name="start_date" class="form-control" value="<?= $subscription['start_date'] ?>" required>
        </div>

        <div class="mb-3">
            <label>End Date:</label>
            <input type="date" name="end_date" class="form-control" value="<?= $subscription['end_date'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Price ($):</label>
            <input type="number" name="price" class="form-control" value="<?= $subscription['price'] ?>" step="0.01" required>
        </div>

        <div class="mb-3">
            <label>Status:</label>
            <select name="status" class="form-control" required>
                <option value="active" <?= $subscription['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                <option value="expired" <?= $subscription['status'] == 'expired' ? 'selected' : '' ?>>Expired</option>
                <option value="cancelled" <?= $subscription['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Subscription</button>
    </form>

    <a href="subscriptions.php" class="btn btn-secondary mt-3">Back to List</a>
</div>

<?php include('../includes/footer.php'); ?>
