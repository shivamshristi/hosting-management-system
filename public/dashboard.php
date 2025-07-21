<?php
session_start();
require_once __DIR__.'/../classes/User.php';
User::requireLogin();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <title>Dashboard</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Billing System</a>
    <div class="d-flex">
      <a href="/logout.php" class="btn btn-outline-light">Logout</a>
    </div>
  </div>
</nav>
<div class="container mt-4">
  <h3>Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?></h3>
  <ul>
    <li><a href="/products.php">Manage Products</a></li>
    <li><a href="/clients.php">Manage Clients</a></li>
    <li><a href="/invoice.php">Create Invoice</a></li>
  </ul>
</div>
</body>
</html>
