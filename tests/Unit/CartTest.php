<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';

use App\Services\CartService;
use App\Models\Product;
use Vedairo\Database\DB;

// Create SQLite in-memory DB
$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$pdo->exec("
    CREATE TABLE products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        price REAL NOT NULL,
        stock INTEGER NOT NULL DEFAULT 0,
        status INTEGER NOT NULL DEFAULT 1,
        image TEXT NULL,
        created_at TEXT NULL,
        updated_at TEXT NULL
    );
");

$pdo->exec("INSERT INTO products (id, name, price, stock, status) VALUES (1, 'Smartphone', 499.00, 10, 1)");
$pdo->exec("INSERT INTO products (id, name, price, stock, status) VALUES (2, 'Headphones', 79.00, 5, 1)");

$db = new DB($pdo);
\Vedairo\Application::$container->singleton('db', fn() => $db);

$_SESSION['cart'] = [];
$cartService = new CartService();

// Add to cart
$cartService->add(1, 2);
$cartService->add(2, 1);

$items = $cartService->items();
assert($items['count'] === 3, 'Cart items count mismatch');
assert(abs($items['subtotal'] - (499.00 * 2 + 79.00)) < 0.001, 'Cart subtotal mismatch');

// Update item quantity
$cartService->update(1, 3);
$items = $cartService->items();
assert($items['count'] === 4, 'Cart update count mismatch');

// Remove item
$cartService->remove(2);
$items = $cartService->items();
assert($items['count'] === 3, 'Cart remove count mismatch');

// Clear cart
$cartService->clear();
$items = $cartService->items();
assert($items['count'] === 0, 'Cart clear failed');

echo "CartTest: PASS\n";
return true;
