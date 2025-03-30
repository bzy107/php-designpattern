<?php

declare(strict_types=1);

abstract class AbstructPrints
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
        echo ('(' . $this->string . ')') . PHP_EOL;
    }

    public function showWithAster()
    {
        echo ('*' . $this->string . '*') . PHP_EOL;
    }
}

class PrintBanner extends AbstructPrints
{
    private Banner $banner;

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

$pr = new PrintBanner('bbbb');
$pr->printWeak();
$pr->printStrong();
