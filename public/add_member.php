<?php
include('../includes/header.php');
require_once '../config/db.php';

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    try {
        $first_name = trim($_POST['first_name']);
        $last_name  = trim($_POST['last_name']);
        $email      = trim($_POST['email']);
        $phone      = trim($_POST['phone']);
        $dob        = trim($_POST['dob']);
        $gender     = trim($_POST['gender']);
        $password   = trim($_POST['password']);

        // Basic validation
        if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
            $error = "First name, last name, email, and password are required.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare("
                INSERT INTO members (first_name, last_name, email, password, phone, dob, gender) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $first_name,
                $last_name,
                $email,
                $hashedPassword,
                $phone,
                $dob,
                $gender
            ]);

            if ($stmt->rowCount() > 0) {
                $success = "✅ Member added successfully!";
            } else {
                $error = "❌ Failed to add member. Please try again.";
            }
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $error = "❗ Email already exists.";
        } else {
            $error = "❌ Error adding member: " . $e->getMessage();
        }
    }
}
?>

<div class="container mt-4">
    <h2 class="mb-3">Add New Member</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="add_member.php" method="POST" class="form">
        <div class="mb-2">
            <label>First Name:</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Last Name:</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Phone:</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="mb-2">
            <label>Date of Birth:</label>
            <input type="date" name="dob" class="form-control">
        </div>

        <div class="mb-3">
            <label>Gender:</label>
            <select name="gender" class="form-control">
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add Member</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
