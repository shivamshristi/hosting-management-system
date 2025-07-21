<?php
require_once __DIR__ . '/../config/db.php';

class User {
    public static function findByUsername(string $username) {
        $stmt = DB::getInstance()->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public static function create(string $username, string $password, string $role = 'cashier'): bool {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = DB::getInstance()->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
        return $stmt->execute([$username, $hash, $role]);
    }

    public static function verify(string $username, string $password): bool {
        $user = self::findByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    public static function logout(): void {
        unset($_SESSION['user']);
        session_destroy();
    }

    public static function requireLogin(): void {
        if (!isset($_SESSION['user'])) {
            header('Location: /login.php');
            exit;
        }
    }
}
?>
