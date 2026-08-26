<?php
namespace Vedairo\Database;
class Repository {
    public function __construct(protected DB $db, protected string $table) {}


    public function find(int|string $id, string $key = 'id'): ?array { return $this->db->table($this->table)->whereEq($key, $id)->first(); }

    /** @return list<array<string,mixed>> */
    public function all(): array { return $this->db->table($this->table)->get(); }

    /** @param array<string,mixed> $data */
    public function create(array $data): int { return $this->db->table($this->table)->insert($data); }

    /** @param array<string,mixed> $data */
    public function update(int|string $id, array $data, string $key = 'id'): int { return $this->db->table($this->table)->whereEq($key, $id)->update($data); }

    public function delete(int|string $id, string $key = 'id'): int { return $this->db->table($this->table)->whereEq($key, $id)->delete(); }
}
