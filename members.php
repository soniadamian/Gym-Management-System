<?php
require_once '../includes/auth.php';
include('../includes/header.php');
require_once '../config/db.php';

try {
    $stmt = $pdo->query("SELECT id, first_name, last_name, email FROM members");
    $members = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching members: " . $e->getMessage());
}
?>

<div class="container mt-4">
    <h2>Manage Members</h2>
    <a href="add_member.php" class="btn btn-success mb-3">Add New Member</a>

    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">✅ Member successfully deleted.</div>
    <?php endif; ?>

    <?php if (count($members) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th> <!-- ✅ New Column -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($members as $member): ?>
                    <tr>
                        <td><?= htmlspecialchars($member['first_name'] . ' ' . $member['last_name']) ?></td>
                        <td><?= htmlspecialchars($member['email']) ?></td>
                        <td>
                            <form action="delete_member.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this member?');" style="display:inline;">
                                <input type="hidden" name="member_id" value="<?= $member['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No members found.</p>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
