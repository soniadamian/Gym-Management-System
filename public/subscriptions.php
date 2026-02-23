<?php
require_once '../includes/auth.php';
require_once '../config/db.php';
include('../includes/header.php');

try {
    $stmt = $pdo->query("
        SELECT s.*, CONCAT(m.first_name, ' ', m.last_name) AS member_name
        FROM subscriptions s
        LEFT JOIN members m ON s.member_id = m.id
    ");
    $subscriptions = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching subscriptions: " . $e->getMessage());
}
?>

<div class="container mt-4">
    <h2>Manage Subscriptions</h2>
    <a href="add_subscription.php" class="btn btn-success mb-3">Add Subscription</a>

    <?php if (count($subscriptions) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Plan</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subscriptions as $s): ?>
                    <tr>
                        <td><?= htmlspecialchars($s['member_name']) ?></td>
                        <td><?= htmlspecialchars($s['plan_name']) ?></td>
                        <td><?= $s['start_date'] ?></td>
                        <td><?= $s['end_date'] ?></td>
                        <td>$<?= number_format($s['price'], 2) ?></td>
                        <td><?= htmlspecialchars($s['status']) ?></td>
                        <td>
                            <a href="edit_subscription.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="delete_subscription.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this subscription?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No subscriptions found.</p>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
