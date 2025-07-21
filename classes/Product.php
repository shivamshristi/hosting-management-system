<?php
require_once __DIR__ . '/../config/db.php';

class Product {
    public static function all(): array {
        return DB::getInstance()->query('SELECT * FROM products')->fetchAll();
    }

    public static function find(int $id) {
        $stmt = DB::getInstance()->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create(array $data): bool {
        $stmt = DB::getInstance()->prepare('INSERT INTO products (name, hsn, price, stock, expiry_date, barcode) VALUES (?, ?, ?, ?, ?, ?)');
        return $stmt->execute([
            $data['name'],
            $data['hsn'],
            $data['price'],
            $data['stock'],
            $data['expiry_date'],
            $data['barcode']
        ]);
    }

    public static function update(int $id, array $data): bool {
        $stmt = DB::getInstance()->prepare('UPDATE products SET name=?, hsn=?, price=?, stock=?, expiry_date=?, barcode=? WHERE id=?');
        return $stmt->execute([
            $data['name'],
            $data['hsn'],
            $data['price'],
            $data['stock'],
            $data['expiry_date'],
            $data['barcode'],
            $id
        ]);
    }

    public static function delete(int $id): bool {
        $stmt = DB::getInstance()->prepare('DELETE FROM products WHERE id=?');
        return $stmt->execute([$id]);
    }
}
?>
