<?php
require_once '../includes/auth.php';
require_once '../config/db.php';
include('../includes/header.php');

try {
    $stmt = $pdo->query("SELECT * FROM trainers");
    $trainers = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching trainers: " . $e->getMessage());
}
?>

<div class="container mt-4">
    <h2>Manage Trainers</h2>
    <a href="add_trainer.php" class="btn btn-success mb-3">Add New Trainer</a>

    <?php if (count($trainers) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Specialty</th>
                    <th>Phone</th>
                    <th>Hire Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trainers as $trainer): ?>
                    <tr>
                        <td><?= htmlspecialchars($trainer['full_name']) ?></td>
                        <td><?= htmlspecialchars($trainer['specialty']) ?></td>
                        <td><?= htmlspecialchars($trainer['phone']) ?></td>
                        <td><?= htmlspecialchars($trainer['hire_date']) ?></td>
                        <td>
                            <a href="edit_trainer.php?id=<?= $trainer['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="delete_trainer.php?id=<?= $trainer['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this trainer?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No trainers found.</p>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
