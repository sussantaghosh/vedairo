<?php
namespace Vedairo\Console;
final class Console {
    /**
     * @param list<string> $argv
     */
    public static function run(array $argv): void {
        $cmd = $argv[1] ?? 'help';
        switch ($cmd) {
            case 'about':
                echo "VEDAIRO Enterprise 5.0.0\nPHP " . PHP_VERSION . "\n";
                break;

            case 'route:list':
                \Vedairo\Application::boot();
                foreach ((array)\Vedairo\Application::$container->get('router')->routes as $r) echo str_pad($r->method, 7) . " {$r->path}\n";
                break;

            case 'migrate':
                self::migrate();
                break;

            case 'db:seed':
                if (class_exists('\Database\Seeders\DatabaseSeeder')) { \Database\Seeders\DatabaseSeeder::run(); echo "Seeded.\n"; } else { echo "No database seeder found.\n"; }
                break;

            case 'queue:work':
                $w = \Vedairo\Application::$container->get('queueWorker');
                $once = in_array('--once', $argv, true);
                do {
                    $did = $w->runOnce();
                    if (!$did) sleep((int) ($argv[2] ?? 1));
                } while (!$once);
                break;

            case 'schedule:run':
                $s = \Vedairo\Application::$container->get('scheduler');
                $s->runDue();
                echo "Scheduler tick complete.\n";
                break;

            case 'backup':
                $file = $argv[2] ?? ('storage/backups/backup-' . date('Ymd-His') . '.sql');
                if (!is_dir(dirname($file))) mkdir(dirname($file), 0775, true);
                \Vedairo\Application::$container->get('backup')->sql($file);
                echo "Backup: $file\n";
                break;

            case 'cache:clear':
                self::clearCache();
                break;


            case 'test':
                self::tests();
                break;

            case 'serve':
                $port = (int) ($argv[2] ?? '8000');
                passthru(PHP_BINARY . ' -S 127.0.0.1:' . $port . ' -t public public/index.php');
                break;

            default:
                echo "VEDAIRO commands:\n about\n route:list\n migrate\n db:seed\n queue:work [--once]\n schedule:run\n backup [file]\n serve [port]\n test\n";
        }
    }

    private static function migrate(): void {
        $db = new \Vedairo\Database\DB();
        $db->pdo()->exec("CREATE TABLE IF NOT EXISTS vedairo_migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $stmt = $db->pdo()->query("SELECT migration FROM vedairo_migrations");
        $executed = $stmt ? $stmt->fetchAll(\PDO::FETCH_COLUMN) : [];
        $migratedCount = 0;

        $files = glob(base_path('database/migrations/*.sql')) ?: [];
        sort($files);
        foreach ($files as $file) {
            $base = basename($file);
            if (in_array($base, $executed, true)) {
                continue;
            }
            $content = file_get_contents($file);
            if ($content === false) continue;
            $sql = (string) $content;
            $parts = preg_split('/;\s*(?:\r?\n|$)/', $sql) ?: [];
            foreach ($parts as $part) {
                $q = trim((string)$part);
                if (strlen($q) > 0) {
                    $db->pdo()->exec($q);
                }
            }
            $ins = $db->pdo()->prepare("INSERT INTO vedairo_migrations (migration) VALUES (?)");
            $ins->execute([$base]);
            echo "Migrated: $base\n";
            $migratedCount++;
        }

        if ($migratedCount === 0) {
            echo "Nothing to migrate. All migrations are up to date.\n";
        } else {
            echo "Migrations complete ($migratedCount executed).\n";
        }
    }

    private static function clearCache(): void {
        $cacheDir = base_path('storage/cache');
        if (is_dir($cacheDir)) {
            $files = glob($cacheDir . '/*.cache') ?: [];
            foreach ($files as $f) {
                if (is_file($f)) @unlink($f);
            }
        }
        echo "Cache cleared.\n";
    }

    private static function tests(): void {
        echo "Running syntax/runtime smoke tests...\n";
        $units = glob(base_path('tests/Unit/*.php')) ?: [];
        foreach ($units as $f) require_once $f;
        $features = glob(base_path('tests/Feature/*.php')) ?: [];
        foreach ($features as $f) require_once $f;
        echo "Tests completed.\n";
    }
}

