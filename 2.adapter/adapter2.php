<?php
declare(strict_types=1);

use PrintBanner as GlobalPrintBanner;

abstract class Prints
{
    abstract protected function printWeak();
    abstract protected function printStrong();
}

class Banner
{
    public string $string;
    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function showWithParen()
    {
        print("(" . $this->string . ")").PHP_EOL;
    }

    public function showWithAster()
    {
        print("*" . $this->string . "*").PHP_EOL;
    }
}


class PrintBanner extends Prints 
{
    public function __construct(string $string)
    {
        $this->banner = new Banner($string);
    }

    public function printWeak()
    {
        $this->banner->showWithParen();
    }

    public function printStrong()
    {
        $this->banner->showWithAster();
    }
}

$pr = new GlobalPrintBanner('bbbb');
$pr->printWeak();
$pr->printStrong();
