<?php
session_start();
require_once __DIR__.'/../classes/User.php';
require_once __DIR__.'/../classes/Product.php';
User::requireLogin();
$products = Product::all();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <title>Products</title>
</head>
<body>
<div class="container mt-4">
  <h3>Products</h3>
  <table class="table table-bordered">
    <thead><tr><th>ID</th><th>Name</th><th>HSN</th><th>Price</th><th>Stock</th></tr></thead>
    <tbody>
      <?php foreach($products as $p): ?>
      <tr>
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= htmlspecialchars($p['hsn']) ?></td>
        <td><?= $p['price'] ?></td>
        <td><?= $p['stock'] ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>
