<?php

declare(strict_types=1);

interface Character
{
    public function dance();

    public function walk();
}

class Mickey implements Character
{
    private string $name = 'Mickey';

    public function dance()
    {
        echo ($this->name . ' tap dance') . PHP_EOL;
    }

    public function walk()
    {
        echo ($this->name . ' wave hands') . PHP_EOL;
    }
}

class Donald implements Character
{
    private string $name = 'Donald';

    public function dance()
    {
        echo ($this->name . ' butt-wiggling dance') . PHP_EOL;
    }

    public function walk()
    {
        echo ($this->name . ' quack') . PHP_EOL;
    }
}

class Performance
{
    private Character $character;

    public function __construct(Character $character)
    {
        $this->character = $character;
    }

    public function dancePerformance(): void
    {
        $this->character->dance();
    }

    public function walkPerformance(): void
    {
        $this->character->walk();
    }
}

$mickey = new Mickey();
$pf1 = new Performance($mickey);
$pf1->dancePerformance();
$pf1->walkPerformance();

$donald = new Donald();
$pf2 = new Performance($donald);
$pf2->dancePerformance();
$pf2->walkPerformance();
