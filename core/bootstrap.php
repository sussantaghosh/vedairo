<?php
declare(strict_types=1);

if (is_file(dirname(__DIR__) . '/vendor/autoload.php')) {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
}

require_once __DIR__ . '/Support/helpers.php';

require_once __DIR__.'/AI/functions.php';
spl_autoload_register(function(string $class){
    $map=['Vedairo\\'=>__DIR__.'/','App\\'=>dirname(__DIR__).'/app/'];
    foreach($map as $prefix=>$base){
        if(str_starts_with($class,$prefix)){
            $rel=substr($class,strlen($prefix));
            $file=$base.str_replace('\\','/',$rel).'.php';
            if(is_file($file)){require_once $file;return;}
        }
    }
});
foreach(glob(dirname(__DIR__).'/config/*.php') as $f){$name=basename($f,'.php');$GLOBALS['config'][$name]=require $f;}
$seed=dirname(__DIR__).'/database/seeders/DatabaseSeeder.php'; if(is_file($seed)) require_once $seed;
Vedairo\Application::boot();
