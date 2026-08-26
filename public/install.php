<?php
// Remove this file after installation. It is a minimal environment preflight page.
header('Content-Type: text/html; charset=utf-8');
$checks=[
 'PHP >= 8.3'=>version_compare(PHP_VERSION,'8.3.0','>='),
 'PDO'=>extension_loaded('pdo'),
 'PDO MySQL'=>extension_loaded('pdo_mysql'),
 'cURL'=>extension_loaded('curl'),
 'OpenSSL'=>extension_loaded('openssl'),
 'JSON'=>extension_loaded('json'),
 'mbstring'=>extension_loaded('mbstring'),
 'Storage writable'=>is_writable(dirname(__DIR__).'/storage'),
];
?><!doctype html><html><head><meta charset="utf-8"><title>VEDAIRO Installer</title><style>body{font-family:Arial;max-width:800px;margin:40px auto;padding:20px}li{padding:8px}.ok{color:green}.bad{color:#b00}</style></head><body><h1>VEDAIRO Enterprise Installer</h1><p>Copy <code>.env.enterprise.example</code> to <code>.env</code>, configure it, then run <code>php vedairo migrate</code>.</p><ul><?php foreach($checks as $name=>$ok):?><li class="<?= $ok?'ok':'bad'?>"><?=htmlspecialchars($name)?> — <?=$ok?'OK':'FAIL'?></li><?php endforeach;?></ul><p><strong>Security:</strong> delete <code>public/install.php</code> after installation.</p></body></html>
