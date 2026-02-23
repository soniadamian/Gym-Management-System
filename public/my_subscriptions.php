<?php
include('../includes/header.php');
require_once '../config/db.php';

if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit;
}

$member_id = $_SESSION['member_id'];

try {
    $stmt = $pdo->prepare("SELECT plan_name, start_date, end_date, price, status FROM subscriptions WHERE member_id = ? ORDER BY start_date DESC");
    $stmt->execute([$member_id]);
    $subscriptions = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching subscriptions: " . $e->getMessage());
}
?>

<div class="container mt-4">
    <h2>My Subscriptions</h2>

    <?php if (count($subscriptions) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Plan Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subscriptions as $sub): ?>
                    <tr>
                        <td><?= htmlspecialchars($sub['plan_name']) ?></td>
                        <td><?= htmlspecialchars($sub['start_date']) ?></td>
                        <td><?= htmlspecialchars($sub['end_date']) ?></td>
                        <td>$<?= htmlspecialchars(number_format($sub['price'], 2)) ?></td>
                        <td><?= htmlspecialchars(ucfirst($sub['status'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You have no subscriptions yet.</p>
    <?php endif; ?>

    <a href="member_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

<?php include('../includes/footer.php'); ?>

