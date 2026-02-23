<?php
require_once '../includes/auth.php';
include('../includes/header.php');
?>

<style>
    .dashboard-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
        text-align: center;
    }

    .dashboard-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 30px;
    }

    .dashboard-buttons a {
        display: block;
        padding: 15px;
        background-color: #2d6a4f;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .dashboard-buttons a:hover {
        background-color: #40916c;
    }
</style>

<div class="dashboard-container">
    <h2>Welcome to the Gym Management Dashboard</h2>
    <p>Hello, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!
! Use the options below to manage your gym.</p>

    <div class="dashboard-buttons">
        <a href="members.php">Manage Members</a>
        <a href="trainers.php">Manage Trainers</a>
        <a href="subscriptions.php">Manage Subscriptions</a>
        <a href="admin_classes.php">Manage Classes</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
