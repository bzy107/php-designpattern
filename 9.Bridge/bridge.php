<?php


abstract class DisplayImpl
{
    abstract public function rawOpen();
    abstract public function rawPrint();
    abstract public function rawClose();
}

class Display
{
    private DisplayImpl $impl;

    public function __construct(DisplayImpl $impl)
    {
        $this->impl = $impl;
    }

    public function open()
    {
        $this->impl->rawOpen();
    }

    public function print()
    {
        $this->impl->rawPrint();
    }

    public function close()
    {
        $this->impl->rawClose();
    }

    final public function display()
    {
        $this->open();
        $this->print();
        $this->close();
    }
}

class CountDisplay extends Display
{
    public function __construct(DisplayImpl $impl)
    {
        parent::__construct($impl);
    }

    public function multiDisplay(int $times)
    {
        $this->open();
        for ($i=0; $i<$times; $i++) {
            $this->print();
        }
        $this->close();
    }
}

class StringDisplayImpl extends DisplayImpl
{
    private string $string;
    private int $width;

    public function __construct(string $string)
    {
        $this->string = $string;
        $this->width = strlen($string);
    }

    public function rawOpen()
    {
        $this->printLine();
    }

    public function rawPrint()
    {
        print('|' . $this->string . '|').PHP_EOL;
    }

    public function rawClose()
    {
        $this->printLine();
    }


    private function printLine()
    {
        print("+");
        for ($i=0; $i<$this->width; $i++) {
            print('-');
        }
        print("+").PHP_EOL;
    }
}


$d1 = new Display(new StringDisplayImpl('hello World!!!'));
$d1->display();

$d2 = new CountDisplay(new StringDisplayImpl('hello, www'));
$d2->multiDisplay(5);
