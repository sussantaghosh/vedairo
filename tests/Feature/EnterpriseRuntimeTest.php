<?php
$checks=[
 is_file(__DIR__.'/../../core/Authorization/Authorization.php'),
 is_file(__DIR__.'/../../core/AI/RAG.php'),
 is_file(__DIR__.'/../../core/Jobs/DatabaseQueue.php'),
 is_file(__DIR__.'/../../core/Queue/Worker.php'),
 is_file(__DIR__.'/../../database/migrations/005_complete_enterprise.sql'),
 class_exists('Vedairo\\AI\\GeminiProvider'),
 class_exists('Vedairo\\Security\\RateLimiter'),
];
if(!in_array(false,$checks,true)){echo "Enterprise runtime checks: PASS\n";return true;}echo "Enterprise runtime checks: FAIL\n";return false;
