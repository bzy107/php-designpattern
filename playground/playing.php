<?php

declare(strict_types=1);



$arg = '111';
$closure = function($arg) {
    return $arg . ' is closure'.PHP_EOL;
};

echo $closure('222');


$person = 'He';
$greet = function($say) use ($person) {
    echo $person . ' says ' . $say .PHP_EOL;
};


$person = 'You';
$greet('Hello world');


function callbackGreet($name, $callback) {
    echo $callback($name) . ' <-- this is callback function result' . PHP_EOL;
}


callbackGreet('watasi', function($name) {
    return 'ここはどこ？' . $name . ' はだれ？';
});


$callback1 = function($name) {
    echo '1 '  , $name , ' for callback'.PHP_EOL;
};

$callback2 = function($name) {
    echo '2 ' , $name  . ' has args' . PHP_EOL;
};

function dispatcher($name, $callback) {
    $callback($name);
}

dispatcher('one user', $callback1);
dispatcher('two user', $callback2);



class Learn
{
    private $name = 'name';
}




class Users
{
    private $user = 'user';
    
    public static function getClass()
    {
        // echo __CLASS__.PHP_EOL;
        echo get_class().PHP_EOL;
        // echo self::class.PHP_EOL;
        // echo static::class.PHP_EOL;
    }
}


Users::getClass();

