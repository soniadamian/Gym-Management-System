<?php include('../includes/header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GymX - Home</title>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            text-align: center;
            padding: 60px;
            background: linear-gradient(135deg, #0d0d0d, #1a1a1a);
            color: #e0e0e0;
        }
        h1 {
            color: #a8e063;
            font-size: 3em;
            margin-bottom: 0.2em;
            animation: fadeIn 1s ease-out;
        }
        .info {
            max-width: 600px;
            margin: 0 auto 40px;
            font-size: 1.1em;
            line-height: 1.6;
            color: #c0c0c0;
            animation: fadeIn 1s ease-out 0.3s both;
        }
        .buttons {
            animation: fadeIn 1s ease-out 0.6s both;
        }
        .buttons a {
            display: inline-block;
            margin: 10px;
            padding: 14px 28px;
            background-color: #264d00;
            color: #f1f1f1;
            text-decoration: none;
            border-radius: 6px;
            border: 2px solid #a8e063;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }
        .buttons a:hover {
            background-color: #a8e063;
            color: #121212;
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 4px 12px rgba(0,0,0,0.5);
        }
        .buttons a:active {
            transform: translateY(0) scale(0.98);
            box-shadow: 0 2px 6px rgba(0,0,0,0.7);
        }
    </style>
</head>
<body>
    <h1>Welcome to GymX</h1>
    <p class="info">
        A complete gym management system where you can manage members, trainers, classes, and subscriptions with ease.
    </p>

    <div class="buttons">
        <a href="login.php">Admin/Staff Login</a>
        <a href="member_login.php">Member Login</a>
        <a href="register_user.php">Register User</a>
        <a href="add_member.php">Register Member</a>
    </div>
</body>
</html>

<?php include('../includes/footer.php'); ?>
