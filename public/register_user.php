<?php
include('../includes/header.php');
require_once '../config/db.php';

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role     = trim($_POST['role']);

    if (empty($username) || empty($password) || empty($role)) {
        $error = "All fields are required.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$username, $hashedPassword, $role]);
            $success = "User registered successfully!";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = "Username already exists.";
            } else {
                $error = "Error: " . $e->getMessage();
            }
        }
    }
}
?>

<h2 style="text-align:center;color:#9f3;">Register New User</h2>

<?php if ($success): ?>
    <p style="color:green; text-align:center;"><?= $success ?></p>
<?php elseif ($error): ?>
    <p style="color:red; text-align:center;"><?= $error ?></p>
<?php endif; ?>

<form method="POST" class="form-center">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Role:</label><br>
    <select name="role" required>
        <option value="">Select role</option>
        <option value="admin">Admin</option>
        <option value="staff">Staff</option>
    </select><br><br>

    <button type="submit" class="button">Register User</button>
</form>

<?php include('../includes/footer.php'); ?>
