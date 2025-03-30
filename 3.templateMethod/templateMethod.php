<?php

abstract class AbstractDisplay
{
    abstract public function opens(): void;

    abstract public function prints(): void;

    abstract public function closes(): void;

    final public function display(): void
    {
        $this->opens();
        for ($i = 0; $i < 5; $i++) {
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

    public function opens(): void
    {
        echo '<<';
    }

    public function prints(): void
    {
        echo $this->string;
    }

    public function closes(): void
    {
        echo '>>' . PHP_EOL;
    }
}

echo '-----CharDsiplay--------' . PHP_EOL;
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

    public function printLine(): void
    {
        echo '+';
        for ($i = 0; $i < $this->length; $i++) {
            echo '-';
        }
        echo '+' . PHP_EOL;
    }

    public function opens(): void
    {
        $this->printLine();
    }

    public function prints(): void
    {
        echo ('|' . $this->string . '|') . PHP_EOL;
    }

    public function closes(): void
    {
        $this->printLine();
    }
}

echo '-----StringDisplay--------' . PHP_EOL;
$sd = new StringDisplay('oooooiiiiiii');
$sd->display();
