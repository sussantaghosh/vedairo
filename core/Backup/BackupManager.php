<?php
namespace Vedairo\Backup;

use Vedairo\Database\DB;

final class BackupManager
{
    public function __construct(private DB $db)
    {
    }

    public function sql(string $file): void
    {
        $fh = fopen($file, 'wb');
        if ($fh === false) {
            throw new \RuntimeException('Unable to open backup file for writing: ' . $file);
        }

        $tables = $this->db->query('SHOW TABLES')->fetchAll();
        foreach ($tables as $row) {
            $t = array_values($row)[0];
            $create = $this->db->query("SHOW CREATE TABLE `{$t}`")->fetch();
            fwrite($fh, "DROP TABLE IF EXISTS `{$t}`;\n" . $create['Create Table'] . ";\n");

            $rows = $this->db->query("SELECT * FROM `{$t}`")->fetchAll();
            foreach ($rows as $r) {
                $cols = array_map(fn ($c) => '`' . $c . '`', array_keys($r));
                $vals = array_map(fn ($v) => $v === null ? 'NULL' : $this->db->pdo()->quote((string) $v), array_values($r));
                fwrite($fh, 'INSERT INTO `' . $t . '` (' . implode(',', $cols) . ') VALUES (' . implode(',', $vals) . ');' . "\n");
            }
        }

        fclose($fh);
    }
}
