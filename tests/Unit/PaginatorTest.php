<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';

use Vedairo\Database\Paginator;

$items = [['id' => 1], ['id' => 2]];
$paginator = new Paginator($items, 55, 10, 2, '/products', ['q' => 'phone']);

assert($paginator->total === 55);
assert($paginator->perPage === 10);
assert($paginator->page === 2);
assert($paginator->lastPage() === 6);
assert($paginator->hasPages() === true);
assert(str_contains($paginator->url(3), 'page=3'));
assert(str_contains($paginator->url(3), 'q=phone'));
assert(str_contains($paginator->links(), '<nav aria-label="Pagination">'));

echo "PaginatorTest: PASS\n";
return true;
