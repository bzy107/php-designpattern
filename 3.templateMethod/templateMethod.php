<?php

use phpDocumentor\Reflection\Types\AbstractList;

abstract class AbstractDisplay
{
    abstract public function opens() : void;
    abstract public function prints() : void;
    abstract public function closes() : void;
    final public function display() : void
    {
        $this->opens();
        for ($i=0; $i<5; $i++)
        {
            $this->prints();
        }
        $this->closes();
    }
}


class CharDsiplay extends AbstractDisplay
{
    private string $string;
    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function opens() : void
    {
        print('<<');
    }

    public function prints() : void
    {
        print($this->string);
    }

    public function closes() : void
    {
        print('>>').PHP_EOL;
    }
}

print('-----CharDsiplay--------').PHP_EOL;
$cd = new CharDsiplay('ab');
$cd->display();



class StringDisplay extends AbstractDisplay
{
    private string $string;
    private int $length;

    public function __construct(string $string)
    {
        $this->string = $string;
        $this->length = strlen($string);
    }

    public function printLine() : void
    {
        print('+');
        for ($i=0; $i<$this->length; $i++)
        {
            print('-');
        }
        print('+').PHP_EOL;
    }

    public function opens() : void
    {
        $this->printLine();
    }

    public function prints() : void
    {
        print('|'. $this->string . '|').PHP_EOL;
    }

    public function closes() : void
    {
        $this->printLine();
    }
}

print('-----StringDisplay--------').PHP_EOL;
$sd = new StringDisplay('oooooiiiiiii');
$sd->display();