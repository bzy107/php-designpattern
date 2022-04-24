<?php

class Singleton
{
    private static $singleton;
    private function __construct()
    {
        print('create instance!!');
    }

    public static function getInstance()
    {
        return self::$singleton;
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




