<?php
require_once '../includes/auth.php';
require_once '../config/db.php';
include('../includes/header.php');

$success = $error = "";

// Get members for dropdown
$members = $pdo->query("SELECT id, first_name, last_name FROM members")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = (int) $_POST['member_id'];
    $plan_name = trim($_POST['plan_name']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $price = (float) $_POST['price'];
    $status = $_POST['status'];

    if ($member_id && $plan_name && $start_date && $end_date && $price >= 0 && in_array($status, ['active','expired','cancelled'])) {
        try {
            $stmt = $pdo->prepare("INSERT INTO subscriptions (member_id, plan_name, start_date, end_date, price, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$member_id, $plan_name, $start_date, $end_date, $price, $status]);
            $success = "Subscription added successfully.";
        } catch (PDOException $e) {
            $error = "Error adding subscription: " . $e->getMessage();
        }
    } else {
        $error = "Please complete all fields correctly.";
    }
}
?>

<div class="container mt-4">
    <h2>Add Subscription</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Member:</label>
            <select name="member_id" class="form-control" required>
                <option value="">Select Member</option>
                <?php foreach ($members as $m): ?>
                    <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['first_name'] . ' ' . $m['last_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Plan Name:</label>
            <input type="text" name="plan_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Start Date:</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>End Date:</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Price ($):</label>
            <input type="number" name="price" class="form-control" min="0" step="0.01" required>
        </div>

        <div class="mb-3">
            <label>Status:</label>
            <select name="status" class="form-control" required>
                <option value="active">Active</option>
                <option value="expired">Expired</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Subscription</button>
    </form>

    <a href="subscriptions.php" class="btn btn-secondary mt-3">Back to List</a>
</div>

<?php include('../includes/footer.php'); ?>
