<?php
namespace Vedairo\Database;
class QueryBuilder {
    /** @var list<string> */
    private array $where = [];

    /** @var array<int|string,mixed> */
    private array $params = [];

    private ?string $order = null;
    private ?int $limit = null, $offset = null;
    private string $cols = '*';
    private ?string $group = null;
    private ?string $having = null;

    public function __construct(private \PDO $pdo, private string $table) {}

    public function select(string $cols = '*'): self { $this->cols = $cols; return $this; }

    public function where(string $col, string $op, mixed $val = null): self { $allowed = ['=', '!=', '<>', '>', '>=', '<', '<=', 'LIKE', 'NOT LIKE']; $op = strtoupper($op); if (!in_array($op, $allowed, true)) throw new \InvalidArgumentException('Invalid operator'); $this->where[] = "`$col` $op ?"; $this->params[] = $val; return $this; }

    public function whereEq(string $c, mixed $v): self { return $this->where($c, '=', $v); }
    public function whereNull(string $c): self { $this->where[] = "`$c` IS NULL"; return $this; }
    public function whereNotNull(string $c): self { $this->where[] = "`$c` IS NOT NULL"; return $this; }

    /** @param array<int|string,mixed> $values */
    public function whereIn(string $c, array $values): self { if (!$values) { $this->where[] = '1=0'; return $this; } $this->where[] = '`' . $c . '` IN (' . implode(',', array_fill(0, count($values), '?')) . ')'; array_push($this->params, ...$values); return $this; }

    public function whereLike(string $c, string $v): self { $this->where[] = '`' . $c . '` LIKE ?'; $this->params[] = '%' . $v . '%'; return $this; }
    public function orderBy(string $c, string $dir = 'ASC'): self { $this->order = '`' . $c . '` ' . (strtoupper($dir) === 'DESC' ? 'DESC' : 'ASC'); return $this; } public function limit(int $n): self { $this->limit = max(0, $n); return $this; } public function offset(int $n): self { $this->offset = max(0, $n); return $this; }

    public function groupBy(string $cols): self { $this->group = $cols; return $this; } public function having(string $expr): self { $this->having = $expr; return $this; }

    private function baseSql(): string { $sql = 'SELECT ' . $this->cols . ' FROM `' . $this->table . '`'; if ($this->where) $sql .= ' WHERE ' . implode(' AND ', $this->where); if ($this->group) $sql .= ' GROUP BY ' . $this->group; if ($this->having) $sql .= ' HAVING ' . $this->having; if ($this->order) $sql .= ' ORDER BY ' . $this->order; if ($this->limit !== null) $sql .= ' LIMIT ' . $this->limit; if ($this->offset !== null) $sql .= ' OFFSET ' . $this->offset; return $sql; }

    /** @return list<array<string,mixed>> */
        public function get(): array { $s = $this->pdo->prepare($this->baseSql()); $s->execute($this->params); return array_values($s->fetchAll()); }

        /** @return array<string,mixed>|null */
        public function first(): ?array { $this->limit = 1; $x = $this->get(); return $x[0] ?? null; }

    public function count(): int { $sql = 'SELECT COUNT(*) FROM `' . $this->table . '`'; if ($this->where) $sql .= ' WHERE ' . implode(' AND ', $this->where); $s = $this->pdo->prepare($sql); $s->execute($this->params); return (int) $s->fetchColumn(); }

    public function paginate(int $perPage = 20, int $page = 1, string $path = '/'): Paginator { $page = max(1, $page); $perPage = max(1, min(200, $perPage)); $total = $this->count(); $this->limit($perPage)->offset(($page - 1) * $perPage); return new Paginator($this->get(), $total, $perPage, $page, $path, $_GET); }

    /** @param array<string,mixed> $data */
    public function insert(array $data): int { $cols = array_keys($data); $sql = 'INSERT INTO `' . $this->table . '` (`' . implode('`,`', $cols) . '`) VALUES (' . implode(',', array_fill(0, count($cols), '?')) . ')'; $s = $this->pdo->prepare($sql); $s->execute(array_values($data)); return (int) $this->pdo->lastInsertId(); }

    /** @param array<string,mixed> $data */
    public function update(array $data): int { if (!$data) return 0; $set = []; $p = []; foreach ($data as $c => $v) { $set[] = "`$c` = ?"; $p[] = $v; } $sql = 'UPDATE `' . $this->table . '` SET ' . implode(',', $set); if ($this->where) $sql .= ' WHERE ' . implode(' AND ', $this->where); $s = $this->pdo->prepare($sql); $s->execute(array_merge($p, $this->params)); return $s->rowCount(); }

    public function delete(): int { $sql = 'DELETE FROM `' . $this->table . '`'; if ($this->where) $sql .= ' WHERE ' . implode(' AND ', $this->where); $s = $this->pdo->prepare($sql); $s->execute($this->params); return $s->rowCount(); }

    /** @param array<int|string,mixed> $params
         * @return list<array<string,mixed>>
         */
        public function raw(string $sql, array $params = []): array { $s = $this->pdo->prepare($sql); $s->execute($params); return array_values($s->fetchAll()); }
}
