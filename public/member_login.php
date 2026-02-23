<?php
include('../includes/header.php');
require_once '../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
        $stmt = $pdo->prepare("SELECT id, email, password, first_name FROM members WHERE email = ?");
        $stmt->execute([$email]);
        $member = $stmt->fetch();

        if ($member && password_verify($password, $member['password'])) {
            session_regenerate_id(true);
            $_SESSION['member_id'] = $member['id'];
            $_SESSION['member_email'] = $member['email'];
            $_SESSION['member_name'] = $member['first_name']; 

            
            header("Location: member_dashboard.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    } catch (PDOException $e) {
        $error = "Login error: " . $e->getMessage();
    }
}
?>

<h2>Member Login</h2>

<?php if ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" class="login-form">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" class="button">Login</button>
</form>

<?php include('../includes/footer.php'); ?>
