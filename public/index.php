<?php
require_once '../includes/auth.php';
include('../includes/header.php');
require_once '../config/db.php';

$counts = [];
$counts['members'] = $pdo->query("SELECT COUNT(*) FROM members")->fetchColumn();
$counts['trainers'] = $pdo->query("SELECT COUNT(*) FROM trainers")->fetchColumn();
$counts['classes'] = $pdo->query("SELECT COUNT(*) FROM classes")->fetchColumn();
$counts['active_subs'] = $pdo
    ->query("SELECT COUNT(*) FROM subscriptions WHERE status = 'active'")
    ->fetchColumn();


$stmt = $pdo->query("SELECT first_name, last_name, created_at 
                     FROM members 
                     ORDER BY created_at DESC 
                     LIMIT 5");
$recent = $stmt->fetchAll();
?>

<h2>Dashboard</h2>

<div class="dashboard">
  <div class="card">
    <h3>Members</h3>
    <p><?= $counts['members'] ?></p>
  </div>
  <div class="card">
    <h3>Trainers</h3>
    <p><?= $counts['trainers'] ?></p>
  </div>
  <div class="card">
    <h3>Classes</h3>
    <p><?= $counts['classes'] ?></p>
  </div>
  <div class="card">
    <h3>Active Subs</h3>
    <p><?= $counts['active_subs'] ?></p>
  </div>
</div>

<h3>Recently Joined Members</h3>
<table border="0" cellpadding="8" style="margin:auto;">
  <tr style="color:#a8e063;">
    <th>Name</th>
    <th>Joined At</th>
  </tr>
  <?php foreach ($recent as $m): ?>
    <tr>
      <td><?= htmlspecialchars($m['first_name'].' '.$m['last_name']) ?></td>
      <td><?= htmlspecialchars($m['created_at']) ?></td>
    </tr>
  <?php endforeach; ?>
</table>

<?php include('../includes/footer.php'); ?>

