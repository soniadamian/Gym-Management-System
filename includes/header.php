<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// NOTE: no auth redirect here for public pages
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Gym Management System</title>
  <!--
    This must point to your CSS inside public/assets/css,
    regardless of which public page is including it:
  -->
 <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav>
  <a href="home.php">Home</a> |
  <a href="index.php">Dashboard</a> |
  <a href="members.php">Members</a> |
  <a href="add_member.php">Add Member</a> |
  <a href="register_user.php">Register</a> |
  <a href="logout.php">Logout</a>
</nav>
<hr>
<main>
