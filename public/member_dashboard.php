<?php
session_start();
include('../includes/header.php');


if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['member_name']) ?>!</h2>
    <p>Select an action below:</p>

    <ul>
        <li><a href="view_profile.php">View/Edit Profile</a></li>
        <li><a href="available_classes.php">View and Enroll in Classes</a></li>
        <li><a href="my_subscriptions.php">My Subscriptions</a></li>
        <li><a href="member_logout.php" class="text-danger">Logout</a></li>
        <li><a href="my_classes.php">My Class Bookings</a></li>
        <a href="my_subscriptions.php" class="btn btn-primary">View My Subscriptions</a>

    </ul>
</div>

<?php include('../includes/footer.php'); ?>
