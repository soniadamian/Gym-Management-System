<?php
require_once '../includes/auth.php';
require_once '../config/db.php';
include('../includes/header.php');

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_name = trim($_POST['class_name']);
    $description = trim($_POST['description']);
    $capacity = (int) $_POST['capacity'];

    if ($class_name && $capacity > 0) {
        try {
            $stmt = $pdo->prepare("INSERT INTO classes (class_name, description, capacity) VALUES (?, ?, ?)");
            $stmt->execute([$class_name, $description, $capacity]);
            $success = "Class added successfully.";
        } catch (PDOException $e) {
            $error = "Error adding class: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<div class="container mt-4">
    <h2>Add New Class</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="class_name">Class Name:</label>
            <input type="text" name="class_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="capacity">Capacity:</label>
            <input type="number" name="capacity" class="form-control" required min="1">
        </div>

        <button type="submit" class="btn btn-primary">Add Class</button>
    </form>

    <a href="admin_classes.php" class="btn btn-secondary mt-3">Back to Class List</a>
</div>

<?php include('../includes/footer.php'); ?>
