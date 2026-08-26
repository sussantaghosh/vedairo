<?php
namespace Vedairo\Database;
final class Relations {
    /** @return list<array<string,mixed>> */
    public static function hasMany(Model $model, string $class, string $foreignKey, string $localKey = 'id'): array { $id = $model->getAttribute($localKey); return $class::where($foreignKey, $id)->get(); }

    /** @return array<string,mixed>|null */
    public static function belongsTo(Model $model, string $class, string $foreignKey, string $ownerKey = 'id'): ?array { $id = $model->getAttribute($foreignKey); return $id === null ? null : $class::find((int)$id, $ownerKey); }

    /** @return array<string,mixed>|null */
    public static function hasOne(Model $model, string $class, string $foreignKey, string $localKey = 'id'): ?array { $id = $model->getAttribute($localKey); return $class::where($foreignKey, $id)->first(); }
}
