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
            $dbName = (string) env('DB_DATABASE', 'vedairo');
            $host = (string) env('DB_HOST', '127.0.0.1');
            $port = (string) env('DB_PORT', '3306');
            $user = (string) env('DB_USERNAME', 'root');
            $pass = (string) env('DB_PASSWORD', '');
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                $dsn = 'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $dbName . ';charset=utf8mb4';
                $this->pdo = new \PDO($dsn, $user, $pass, $options);
            } catch (\PDOException $e) {
                // If the database does not exist (MySQL 1049), auto-create it
                if ($e->getCode() == 1049 || str_contains($e->getMessage(), 'Unknown database') || str_contains($e->getMessage(), '1049')) {
                    $serverDsn = 'mysql:host=' . $host . ';port=' . $port . ';charset=utf8mb4';
                    $serverPdo = new \PDO($serverDsn, $user, $pass, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
                    $safeDbName = str_replace('`', '``', $dbName);
                    $serverPdo->exec("CREATE DATABASE IF NOT EXISTS `{$safeDbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

                    $dsn = 'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $dbName . ';charset=utf8mb4';
                    $this->pdo = new \PDO($dsn, $user, $pass, $options);
                } else {
                    throw $e;
                }
            }
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

