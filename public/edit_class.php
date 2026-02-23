<?php
require_once '../includes/auth.php';
require_once '../config/db.php';
include('../includes/header.php');


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin_classes.php");
    exit;
}

$class_id = (int)$_GET['id'];
$success = $error = "";


try {
    $stmt = $pdo->prepare("SELECT * FROM classes WHERE id = ?");
    $stmt->execute([$class_id]);
    $class = $stmt->fetch();

    if (!$class) {
        $error = "Class not found.";
    }
} catch (PDOException $e) {
    $error = "Error fetching class: " . $e->getMessage();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_name = trim($_POST['class_name']);
    $description = trim($_POST['description']);
    $capacity = (int)$_POST['capacity'];

    if ($class_name && $capacity > 0) {
        try {
            $stmt = $pdo->prepare("UPDATE classes SET class_name = ?, description = ?, capacity = ? WHERE id = ?");
            $stmt->execute([$class_name, $description, $capacity, $class_id]);
            $success = "Class updated successfully.";

            // Refresh class details
            $stmt = $pdo->prepare("SELECT * FROM classes WHERE id = ?");
            $stmt->execute([$class_id]);
            $class = $stmt->fetch();
        } catch (PDOException $e) {
            $error = "Error updating class: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<div class="container mt-4">
    <h2>Edit Class</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($class): ?>
    <form method="POST">
        <div class="mb-3">
            <label for="class_name">Class Name:</label>
            <input type="text" name="class_name" class="form-control" value="<?= htmlspecialchars($class['class_name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($class['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="capacity">Capacity:</label>
            <input type="number" name="capacity" class="form-control" value="<?= htmlspecialchars($class['capacity']) ?>" required min="1">
        </div>

        <button type="submit" class="btn btn-primary">Update Class</button>
        <a href="admin_classes.php" class="btn btn-secondary">Back</a>
    </form>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
