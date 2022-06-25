<?php

declare(strict_types=1);


abstract class Beverage
{
    public string $description = "不明な飲み物";
    public function getDescription() : string
    {
        return $this->description;
    }

    public abstract function cost(): float; 
}

abstract class CondimentDecorator extends Beverage
{
    public Beverage $beverage;
    public function __construct(Beverage $beverage)
    {
        $this->beverage = $beverage;
    }
}

class DarkRoast extends Beverage
{
    public function __construct()
    {
        $this->description = "ダークローストコーヒー";
    }

    public function cost(): float
    {
        return 2.99;
    }
}

class Espresso extends Beverage
{
    public function __construct()
    {
        $this->description = "エスプレッソ";
    }

    public function cost(): float
    {
        return 1.99;
    }
}


class HouseBlend extends Beverage
{
    public function __construct()
    {
        $this->description = "ハウスブレンドコーヒー";
    }

    public function cost(): float
    {
        return 0.89;
    }
}

class Soy extends CondimentDecorator
{
    public function getDescription(): string
    {
        return $this->beverage->getDescription() . ', 豆乳';
    }

    public function cost(): float
    {
        return $this->beverage->cost() + 0.30;
    }
}

class Mocha extends CondimentDecorator
{
    public function getDescription(): string
    {
        return $this->beverage->getDescription() . ', モカ';
    }

    public function cost(): float
    {
        return $this->beverage->cost() + 0.20;
    }
}

class Whip extends CondimentDecorator
{
    public function getDescription(): string
    {
        return $this->beverage->getDescription() . ', ホイップ';
    }

    public function cost(): float
    {
        return $this->beverage->cost() + 0.30;
    }
}


$beverage = new Espresso();
print($beverage->getDescription() . ' $' . $beverage->cost()).PHP_EOL;


$beverage2 = new DarkRoast();
$beverage2 = new Mocha($beverage2);
$beverage2 = new Mocha($beverage2);
$beverage2 = new Whip($beverage2);
print($beverage2->getDescription() . ' $' . $beverage2->cost()).PHP_EOL;


$beverage3 = new HouseBlend();
$beverage3 = new Soy($beverage3);
$beverage3 = new Mocha($beverage3);
$beverage3 = new Whip($beverage3);
print($beverage3->getDescription() . ' $' . $beverage3->cost()).PHP_EOL;



