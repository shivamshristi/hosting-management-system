<?php
require_once __DIR__ . '/../config/db.php';

class Client {
    public static function all(): array {
        return DB::getInstance()->query('SELECT * FROM clients')->fetchAll();
    }

    public static function create(array $data): bool {
        $stmt = DB::getInstance()->prepare('INSERT INTO clients (name, email, phone, gstin) VALUES (?, ?, ?, ?)');
        return $stmt->execute([$data['name'], $data['email'], $data['phone'], $data['gstin']]);
    }
}
?>
