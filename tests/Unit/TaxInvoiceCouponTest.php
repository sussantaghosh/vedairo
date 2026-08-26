<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';

use Vedairo\Business\Tax;
use Vedairo\Business\Coupon;
use Vedairo\Business\Invoice;
use Vedairo\Database\DB;

// Create SQLite in-memory database wrapper for testing Business services
$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

// Create test schema
$pdo->exec("
    CREATE TABLE tax_rates (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        rate REAL NOT NULL,
        active INTEGER NOT NULL DEFAULT 1
    );
    CREATE TABLE coupons (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        code TEXT NOT NULL UNIQUE,
        type TEXT NOT NULL,
        value REAL NOT NULL,
        active INTEGER NOT NULL DEFAULT 1,
        starts_at TEXT NULL,
        ends_at TEXT NULL,
        usage_limit INTEGER NULL,
        used_count INTEGER NOT NULL DEFAULT 0
    );
    CREATE TABLE invoices (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        order_id INTEGER NOT NULL,
        invoice_no TEXT NOT NULL,
        subtotal REAL NOT NULL,
        tax REAL NOT NULL,
        discount REAL NOT NULL,
        total REAL NOT NULL,
        status TEXT NOT NULL
    );
");

// Insert fixtures
$pdo->exec("INSERT INTO tax_rates (id, rate, active) VALUES (1, 18.0, 1)");
$pdo->exec("INSERT INTO coupons (code, type, value, active, used_count) VALUES ('SAVE10', 'percent', 10.0, 1, 0)");
$pdo->exec("INSERT INTO coupons (code, type, value, active, used_count) VALUES ('FLAT50', 'fixed', 50.0, 1, 0)");

$db = new DB($pdo);

// Test Tax
$tax = new Tax($db);
$taxAmount = $tax->rate(1000.0, 1);
assert(abs($taxAmount - 180.0) < 0.001, 'Tax calculation mismatch');

// Test Coupon
$coupon = new Coupon($db);
$discountPercent = $coupon->discount('SAVE10', 500.0);
assert(abs($discountPercent - 50.0) < 0.001, 'Percent coupon discount mismatch');

$discountFixed = $coupon->discount('FLAT50', 500.0);
assert(abs($discountFixed - 50.0) < 0.001, 'Fixed coupon discount mismatch');

$coupon->consume('SAVE10');
$updatedCoupon = $db->query("SELECT used_count FROM coupons WHERE code='SAVE10'")->fetch();
assert((int)$updatedCoupon['used_count'] === 1, 'Coupon consume failed');

// Test Invoice
$invoice = new Invoice($db);
$invoiceId = $invoice->create(101, 1000.0, 180.0, 50.0, 1130.0);
assert($invoiceId > 0, 'Invoice create failed');

$savedInvoice = $db->table('invoices')->whereEq('id', $invoiceId)->first();
assert($savedInvoice !== null, 'Invoice record not found');
assert(str_starts_with($savedInvoice['invoice_no'], 'INV-'), 'Invoice number format invalid');
assert((float)$savedInvoice['total'] === 1130.0, 'Invoice total mismatch');

echo "TaxInvoiceCouponTest: PASS\n";
return true;

