<?php
namespace Vedairo\Console;
final class Commands {
    /** @return list<string> */
    public static function list(): array { return ['serve','route:list','migrate','seed','queue:work','schedule:run','cache:clear','make:controller','make:model','make:migration','backup','health']; }
}
