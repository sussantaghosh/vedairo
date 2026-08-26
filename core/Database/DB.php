<?php
namespace Vedairo\Database;

class DB {
    private \PDO $pdo;

    public function __construct(?\PDO $pdo = null) {
        if ($pdo !== null) {
            $this->pdo = $pdo;
            return;
        }

        $connection = (string) env('DB_CONNECTION', 'mysql');
        if ($connection === 'sqlite') {
            $database = (string) env('DB_DATABASE', ':memory:');
            $dsn = 'sqlite:' . ($database === ':memory:' ? ':memory:' : base_path($database));
            $this->pdo = new \PDO($dsn, null, null, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } else {
            $dsn = 'mysql:host=' . env('DB_HOST', '127.0.0.1') . ';port=' . env('DB_PORT', '3306') . ';dbname=' . env('DB_DATABASE', 'vedairo') . ';charset=utf8mb4';
            $this->pdo = new \PDO($dsn, env('DB_USERNAME', 'root'), env('DB_PASSWORD', ''), [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }
    }

    public function pdo(): \PDO {
        return $this->pdo;
    }

    /**
     * @param array<int|string,mixed> $params
     */
    public function query(string $sql, array $params = []): \PDOStatement {
        $s = $this->pdo->prepare($sql);
        $s->execute($params);
        return $s;
    }

    public function transaction(callable $cb): mixed {
        $this->pdo->beginTransaction();
        try {
            $r = $cb($this);
            $this->pdo->commit();
            return $r;
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function table(string $t): QueryBuilder {
        return new QueryBuilder($this->pdo, $t);
    }
}

