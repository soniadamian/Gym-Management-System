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

// Handle booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['class_id'])) {
    $class_id = (int) $_POST['class_id'];

    // Check if already booked
    $check = $pdo->prepare("SELECT id FROM class_bookings WHERE member_id = ? AND class_id = ?");
    $check->execute([$member_id, $class_id]);

    if ($check->rowCount() > 0) {
        $error = "You have already booked this class.";
    } else {
        // Check if class is full
        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM class_bookings WHERE class_id = ?");
        $countStmt->execute([$class_id]);
        $currentBookings = $countStmt->fetchColumn();

        $capacityStmt = $pdo->prepare("SELECT capacity FROM classes WHERE id = ?");
        $capacityStmt->execute([$class_id]);
        $capacity = $capacityStmt->fetchColumn();

        if ($currentBookings >= $capacity) {
            $error = "Sorry, this class is full.";
        } else {
            // Proceed with booking
            $insert = $pdo->prepare("INSERT INTO class_bookings (class_id, member_id) VALUES (?, ?)");
            $insert->execute([$class_id, $member_id]);
            $success = "Class booked successfully.";
        }
    }
}

// Fetch all available classes
$stmt = $pdo->query("
    SELECT c.*, 
           IFNULL(t.full_name, 'Unassigned') AS trainer_name,
           (SELECT COUNT(*) FROM class_bookings cb WHERE cb.class_id = c.id) AS booked_count
    FROM classes c
    LEFT JOIN trainers t ON c.trainer_id = t.id
");
$classes = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2>Available Classes</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Description</th>
                <th>Trainer</th>
                <th>Schedule</th>
                <th>Duration</th>
                <th>Capacity</th>
                <th>Booked</th>
                <th>Action</th>
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
                    <td><?= $class['booked_count'] ?></td>
                    <td>
                        <?php if ($class['booked_count'] < $class['capacity']): ?>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="class_id" value="<?= $class['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-success">Book</button>
                            </form>
                        <?php else: ?>
                            <span class="text-danger">Full</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>
