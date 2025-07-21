<?php
session_start();
require_once __DIR__.'/../classes/User.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if (User::verify($username, $password)) {
        header('Location: /dashboard.php');
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Login</title>
  </head>
  <body class="bg-light d-flex align-items-center" style="height:100vh;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h4 class="mb-3">Login</h4>
              <?php if($error): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
              <?php endif; ?>
              <form method="post" action="">
                <div class="mb-3">
                  <label class="form-label">Username</label>
                  <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
