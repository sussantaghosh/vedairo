<?php
require_once __DIR__.'/../../core/bootstrap.php';
return class_exists('Vedairo\\Application') && class_exists('Vedairo\\Routing\\Router') && class_exists('Vedairo\\Database\\DB');
