<?php

class Singleton
{
    private static ?Singleton $instance = null;

    public static function getInstance() : Singleton
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}

print('start').PHP_EOL;

$obj1 = Singleton::getInstance();
$obj2 = Singleton::getInstance();

if ($obj1 === $obj2) {
    print('same').PHP_EOL;
} else {
    print('not same').PHP_EOL;
}




