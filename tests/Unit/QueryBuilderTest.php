<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';

use Vedairo\Database\QueryBuilder;

// Create SQLite in-memory DB
$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$pdo->exec("
    CREATE TABLE products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        price REAL NOT NULL,
        category TEXT NULL,
        stock INTEGER NOT NULL DEFAULT 0
    );
");

// Insert rows using QueryBuilder
$qb = new QueryBuilder($pdo, 'products');
$id1 = $qb->insert(['name' => 'Laptop', 'price' => 999.99, 'category' => 'electronics', 'stock' => 10]);
$id2 = (new QueryBuilder($pdo, 'products'))->insert(['name' => 'Mouse', 'price' => 29.99, 'category' => 'electronics', 'stock' => 50]);
$id3 = (new QueryBuilder($pdo, 'products'))->insert(['name' => 'Desk', 'price' => 199.99, 'category' => 'furniture', 'stock' => 5]);
$id4 = (new QueryBuilder($pdo, 'products'))->insert(['name' => 'Notebook', 'price' => 4.99, 'category' => null, 'stock' => 100]);

assert($id1 === 1 && $id2 === 2 && $id3 === 3 && $id4 === 4, 'Insert IDs mismatch');

// Test whereEq & first
$row = (new QueryBuilder($pdo, 'products'))->whereEq('name', 'Laptop')->first();
assert($row !== null && (float)$row['price'] === 999.99, 'whereEq failed');

// Test whereIn
$rowsIn = (new QueryBuilder($pdo, 'products'))->whereIn('id', [1, 3])->get();
assert(count($rowsIn) === 2, 'whereIn count mismatch');

// Test whereNull & whereNotNull
$nullCategory = (new QueryBuilder($pdo, 'products'))->whereNull('category')->get();
assert(count($nullCategory) === 1 && $nullCategory[0]['name'] === 'Notebook', 'whereNull failed');

$notNullCategory = (new QueryBuilder($pdo, 'products'))->whereNotNull('category')->get();
assert(count($notNullCategory) === 3, 'whereNotNull failed');

// Test orderBy and limit
$ordered = (new QueryBuilder($pdo, 'products'))->orderBy('price', 'DESC')->limit(2)->get();
assert(count($ordered) === 2 && $ordered[0]['name'] === 'Laptop' && $ordered[1]['name'] === 'Desk', 'orderBy DESC failed');

// Test count
$count = (new QueryBuilder($pdo, 'products'))->count();
assert($count === 4, 'count failed');

// Test update
$affected = (new QueryBuilder($pdo, 'products'))->whereEq('id', 1)->update(['price' => 899.99]);
assert($affected === 1, 'update affected rows mismatch');
$updatedRow = (new QueryBuilder($pdo, 'products'))->whereEq('id', 1)->first();
assert((float)$updatedRow['price'] === 899.99, 'updated value mismatch');

// Test delete
$delCount = (new QueryBuilder($pdo, 'products'))->whereEq('id', 4)->delete();
assert($delCount === 1, 'delete count mismatch');
assert((new QueryBuilder($pdo, 'products'))->count() === 3, 'count after delete mismatch');

// Test paginate
$pageResult = (new QueryBuilder($pdo, 'products'))->orderBy('id', 'ASC')->paginate(2, 1, '/products');
assert($pageResult->total === 3, 'paginate total mismatch');
assert(count($pageResult->items) === 2, 'paginate items count mismatch');
assert($pageResult->lastPage() === 2, 'paginate lastPage mismatch');

echo "QueryBuilderTest: PASS\n";
return true;
