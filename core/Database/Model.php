<?php
namespace Vedairo\Database;
abstract class Model {
    protected static string $table;
    protected static string $primaryKey = 'id';
    protected static bool $softDelete = false;

    public static function query(): QueryBuilder { return \Vedairo\Application::$container->get('db')->table(static::$table); }

    /** @return list<array<string,mixed>> */
    public static function all(): array { return static::query()->get(); }

    /** @return array<string,mixed>|null */
    public static function find(int $id): ?array { return static::query()->whereEq(static::$primaryKey, $id)->first(); }

    /** @param array<string,mixed> $data */
    public static function create(array $data): int { return static::query()->insert($data); }

    /** @param array<string,mixed> $data */
    public static function updateById(int $id, array $data): int { return static::query()->whereEq(static::$primaryKey, $id)->update($data); }

    public static function deleteById(int $id): int { return static::query()->whereEq(static::$primaryKey, $id)->delete(); }

    public static function paginate(int $perPage = 20, int $page = 1, string $path = '/'): Paginator { return static::query()->paginate($perPage, $page, $path); }

    /** @return list<array<string,mixed>> */
    public static function hasMany(string $model, string $foreignKey, string $localKey = 'id', int $id = 0): array { return $model::query()->whereEq($foreignKey, $id)->get(); }

    /** @return array<string,mixed>|null */
    public static function belongsTo(string $model, string $foreignKey, string $ownerKey = 'id', int $value = 0): ?array { return $model::query()->whereEq($ownerKey, $value)->first(); }

    public static function transaction(callable $callback): mixed { $db = \Vedairo\Application::$container->get('db'); $pdo = $db->pdo(); $pdo->beginTransaction(); try { $r = $callback($db); $pdo->commit(); return $r; } catch (\Throwable $e) { $pdo->rollBack(); throw $e; } }

    /**
     * Get an attribute value from a model instance (fallback for array-backed models)
     * @param string $key
     * @return mixed
     */
    public function getAttribute(string $key): mixed { return $this->{$key} ?? null; }
}
