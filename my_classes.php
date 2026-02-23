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


if (isset($_POST['cancel_booking'])) {
    $booking_id = (int) $_POST['cancel_booking'];
    $stmt = $pdo->prepare("DELETE FROM class_bookings WHERE id = ? AND member_id = ?");
    $stmt->execute([$booking_id, $member_id]);
    $success = "Booking cancelled successfully.";
}


$stmt = $pdo->prepare("
    SELECT cb.id AS booking_id, c.class_name, c.schedule_time, c.duration_minutes, 
           IFNULL(t.full_name, 'Unassigned') AS trainer_name
    FROM class_bookings cb
    JOIN classes c ON cb.class_id = c.id
    LEFT JOIN trainers t ON c.trainer_id = t.id
    WHERE cb.member_id = ?
    ORDER BY c.schedule_time
");
$stmt->execute([$member_id]);
$bookings = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2>My Class Bookings</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if (count($bookings) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Class</th>
                    <th>Trainer</th>
                    <th>Schedule</th>
                    <th>Duration</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= htmlspecialchars($booking['class_name']) ?></td>
                        <td><?= htmlspecialchars($booking['trainer_name']) ?></td>
                        <td><?= htmlspecialchars($booking['schedule_time']) ?></td>
                        <td><?= htmlspecialchars($booking['duration_minutes']) ?> min</td>
                        <td>
                            <form method="POST" onsubmit="return confirm('Cancel this booking?');">
                                <input type="hidden" name="cancel_booking" value="<?= $booking['booking_id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You haven't booked any classes yet.</p>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
