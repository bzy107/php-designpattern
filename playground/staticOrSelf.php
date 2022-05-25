<?php

declare(strict_types=1);

class ParentClass
{
    protected static $className = 'Parent';

    public function __construct()
    {
        echo 'Parent construct'.PHP_EOL;
    }

    public function getClassName()
    {
        echo self::$className.PHP_EOL; // 定義された時のクラスを指す
        echo static::$className.PHP_EOL; // 実行される時のクラスを指す
    }

    public static function getInstance()
    {
        new self(); // 定義された時のクラスを指す
        new static(); // 実行される時のクラスを指す
    }
}

class ChildClass extends ParentClass
{
    protected static $className = 'Children';

    public function __construct()
    {
        echo 'Children construct'.PHP_EOL;
    }
}

(new ParentClass())->getClassName();
(new ChildClass())->getClassName();


ChildClass::getInstance();