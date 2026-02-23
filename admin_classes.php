<?php
include('../includes/header.php');
require_once '../config/db.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}


// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM classes WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin_classes.php");
    exit;
}

// Fetch all classes
$stmt = $pdo->query("
    SELECT c.*, t.full_name AS trainer_name 
FROM classes c 
LEFT JOIN trainers t ON c.trainer_id = t.id

");
$classes = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2>Manage Classes</h2>
    <a href="add_class.php" class="btn btn-success mb-3">Add New Class</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Class</th>
                <th>Description</th>
                <th>Trainer</th>
                <th>Schedule</th>
                <th>Duration</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($classes as $class): ?>
            <tr>
                <td><?= htmlspecialchars($class['class_name']) ?></td>
                <td><?= htmlspecialchars($class['description']) ?></td>
                <td><?= htmlspecialchars($class['trainer_name']) ?></td>
                <td><?= htmlspecialchars($class['schedule_time']) ?></td>
                <td><?= htmlspecialchars($class['duration_minutes']) ?> min</td>
                <td><?= htmlspecialchars($class['capacity']) ?></td>
                <td>
                    <a href="edit_class.php?id=<?= $class['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="admin_classes.php?delete=<?= $class['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this class?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>
