<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../vendor/autoload.php'; // composer autoload for FPDF

use setasign\Fpdi\Fpdi;

class Invoice {
    public static function create(array $data, array $items): int {
        $db = DB::getInstance();
        $db->beginTransaction();
        $stmt = $db->prepare('INSERT INTO invoices (client_id, date, gst) VALUES (?, ?, ?)');
        $stmt->execute([$data['client_id'], $data['date'], $data['gst']]);
        $invoiceId = $db->lastInsertId();
        $itemStmt = $db->prepare('INSERT INTO invoice_items (invoice_id, product_id, qty, price, tax) VALUES (?, ?, ?, ?, ?)');
        foreach ($items as $item) {
            $itemStmt->execute([$invoiceId, $item['product_id'], $item['qty'], $item['price'], $item['tax']]);
        }
        $db->commit();
        return (int)$invoiceId;
    }

    public static function generatePdf(int $invoiceId): string {
        $db = DB::getInstance();
        $invoice = $db->prepare('SELECT * FROM invoices WHERE id=?');
        $invoice->execute([$invoiceId]);
        $inv = $invoice->fetch();
        $items = $db->prepare('SELECT ii.*, p.name FROM invoice_items ii JOIN products p ON ii.product_id = p.id WHERE invoice_id=?');
        $items->execute([$invoiceId]);
        $rows = $items->fetchAll();

        $pdf = new Fpdi();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(0,10,'Invoice #'.$invoiceId,0,1);
        $pdf->SetFont('Arial','',12);
        foreach ($rows as $row) {
            $pdf->Cell(0,8,$row['name']." x{$row['qty']} - ".$row['price'],0,1);
        }
        $filename = __DIR__ . '/../data/invoice_'.$invoiceId.'.pdf';
        $pdf->Output('F', $filename);
        return $filename;
    }
}
?>
