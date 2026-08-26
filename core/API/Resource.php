<?php
namespace Vedairo\API;
class Resource {
    /**
     * @param array<string,mixed>|null $data
     * @param callable|null $transform
     * @return array<string,mixed>
     */
    public static function item(?array $data, callable $transform = null): array {
        return ['data' => $data === null ? null : ($transform ? $transform($data) : $data)];
    }

    /**
     * @param array<int,array<string,mixed>> $items
     * @param callable|null $transform
     * @return array<string,mixed>
     */
    public static function collection(array $items, callable $transform = null): array {
        return ['data' => $transform ? array_map($transform, $items) : $items];
    }

    /**
     * @param \Vedairo\Database\Paginator $p
     * @param callable|null $transform
     * @return array<string,mixed>
     */
    public static function paginated(\Vedairo\Database\Paginator $p, callable $transform = null): array {
        return ['data' => $transform ? array_map($transform, $p->items) : $p->items, 'meta' => ['current_page' => $p->page, 'per_page' => $p->perPage, 'total' => $p->total, 'last_page' => $p->lastPage()]];
    }
}
