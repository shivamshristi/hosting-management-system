<?php
session_start();
require_once __DIR__.'/../classes/User.php';
require_once __DIR__.'/../classes/Product.php';
require_once __DIR__.'/../classes/Client.php';
require_once __DIR__.'/../classes/Invoice.php';
User::requireLogin();

$products = Product::all();
$clients = Client::all();
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client = $_POST['client'];
    $gst = $_POST['gst'] ?? 0;
    $items = [];
    foreach($_POST['product_id'] as $idx => $pid) {
        $items[] = [
            'product_id' => $pid,
            'qty' => $_POST['qty'][$idx],
            'price' => $_POST['price'][$idx],
            'tax' => $_POST['tax'][$idx]
        ];
    }
    $invoiceId = Invoice::create(['client_id'=>$client, 'date'=>date('Y-m-d'), 'gst'=>$gst], $items);
    $file = Invoice::generatePdf($invoiceId);
    $message = 'Invoice generated: <a href="/download.php?file='.basename($file).'">Download</a>';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <title>Create Invoice</title>
</head>
<body>
<div class="container mt-4">
  <h3>Create Invoice</h3>
  <?php if($message): ?><div class="alert alert-success"><?= $message ?></div><?php endif; ?>
  <form method="post">
    <div class="mb-3">
      <label class="form-label">Client</label>
      <select name="client" class="form-select" required>
        <?php foreach($clients as $c): ?>
        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <table class="table" id="items">
      <thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Tax %</th></tr></thead>
      <tbody>
        <tr>
          <td>
            <select name="product_id[]" class="form-select">
              <?php foreach($products as $p): ?>
              <option value="<?= $p['id'] ?>" data-price="<?= $p['price'] ?>" data-tax="5"><?= htmlspecialchars($p['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </td>
          <td><input type="number" name="qty[]" value="1" class="form-control"></td>
          <td><input type="number" name="price[]" value="0" step="0.01" class="form-control"></td>
          <td><input type="number" name="tax[]" value="0" step="0.01" class="form-control"></td>
        </tr>
      </tbody>
    </table>
    <button type="submit" class="btn btn-primary">Generate</button>
  </form>
</div>
</body>
</html>
