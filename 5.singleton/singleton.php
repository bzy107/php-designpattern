<?php

class Singleton
{
    private static ?Singleton $instance = null;

    public static function getInstance(): Singleton
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
        }

        return static::$instance;
    }
}

echo 'start' . PHP_EOL;

$obj1 = Singleton::getInstance();
$obj2 = Singleton::getInstance();

if ($obj1 === $obj2) {
    echo 'same' . PHP_EOL;
} else {
    echo 'not same' . PHP_EOL;
}
