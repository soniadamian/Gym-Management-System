<?php
require_once '../includes/auth.php';
require_once '../config/db.php';
include('../includes/header.php');

if (!isset($_GET['id'])) {
    die("Trainer ID is required.");
}

$id = (int)$_GET['id'];
$success = $error = "";

$stmt = $pdo->prepare("SELECT * FROM trainers WHERE id = ?");
$stmt->execute([$id]);
$trainer = $stmt->fetch();

if (!$trainer) {
    die("Trainer not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $specialty = trim($_POST['specialty']);
    $phone = trim($_POST['phone']);
    $hire_date = $_POST['hire_date'];

    if ($full_name && $specialty && $hire_date) {
        try {
            $stmt = $pdo->prepare("UPDATE trainers SET full_name = ?, specialty = ?, phone = ?, hire_date = ? WHERE id = ?");
            $stmt->execute([$full_name, $specialty, $phone, $hire_date, $id]);
            $success = "Trainer updated successfully.";
            // Refresh data
            $trainer['full_name'] = $full_name;
            $trainer['specialty'] = $specialty;
            $trainer['phone'] = $phone;
            $trainer['hire_date'] = $hire_date;
        } catch (PDOException $e) {
            $error = "Error updating trainer: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<div class="container mt-4">
    <h2>Edit Trainer</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Full Name:</label>
            <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($trainer['full_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Specialty:</label>
            <input type="text" name="specialty" class="form-control" value="<?= htmlspecialchars($trainer['specialty']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Phone:</label>
            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($trainer['phone']) ?>">
        </div>
        <div class="mb-3">
            <label>Hire Date:</label>
            <input type="date" name="hire_date" class="form-control" value="<?= $trainer['hire_date'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Trainer</button>
    </form>

    <a href="trainers.php" class="btn btn-secondary mt-3">Back to Trainer List</a>
</div>

<?php include('../includes/footer.php'); ?>
