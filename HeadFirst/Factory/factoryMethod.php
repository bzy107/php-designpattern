<?php

declare(strict_types=1);

abstract class PizzaStore
{
    public function orderPizza(string $type)
    {
        $pizza = $this->createPizza($type);

        $pizza->prepare();
        $pizza->bake();
        $pizza->cut();
        $pizza->box();

        return $pizza;
    }

    abstract public function createPizza(string $type);
}

class NYPizzaStore extends PizzaStore
{
    public function createPizza(string $type)
    {
        if ($type === 'チーズ') {
            return new NYStyleCheesePizza();
        }

        return null;
    }
}

class ChicagoPizzaStore extends PizzaStore
{
    public function createPizza(string $type)
    {
        if ($type === 'チーズ') {
            return new ChicagoStyleCheesePizza();
        }

        return null;
    }
}

abstract class Pizza
{
    public string $name;

    public string $dough;

    public string $sauce;

    public array $toppings = [];

    public function prepare()
    {
        echo ($this->name . 'を下準備') . PHP_EOL;
        echo '生地をこねる' . PHP_EOL;
        echo 'ソースを追加' . PHP_EOL;
        echo 'トッピングを追加' . PHP_EOL;
        foreach ($this->toppings as $topping) {
            echo (' ' . $topping) . PHP_EOL;
        }
    }

    public function bake()
    {
        echo '180度で25分焼く' . PHP_EOL;
    }

    public function cut()
    {
        echo 'ピザを扇形にカットする' . PHP_EOL;
    }

    public function box()
    {
        echo 'PizzaStoreの箱にピザを入れる' . PHP_EOL;
    }

    public function getName()
    {
        return $this->name;
    }
}

class NYStyleCheesePizza extends Pizza
{
    public function __construct()
    {
        $this->name = 'ニューヨークスタイルのソース&チーズピザ';
        $this->dough = '薄いクラフト生地';
        $this->sauce = 'マリナーラソース';

        $this->toppings[] = 'すりおろしたレッジャーのチーズ';
    }
}

class ChicagoStyleCheesePizza extends Pizza
{
    public function __construct()
    {
        $this->name = 'シカゴスタイルのディープディッシュチーズピザ';
        $this->dough = '極厚クラフト生地';
        $this->sauce = 'プラムトマトソース';
        $this->toppings[] = 'シュレッドモッツァレラチーズ';
    }

    public function cut()
    {
        echo 'ピザを四角にカットする';
    }
}

$nyStore = new NYPizzaStore();
$chicagoStore = new ChicagoPizzaStore();

$pizza1 = $nyStore->orderPizza('チーズ');
echo ('イーサンの注文は' . $pizza1->getName()) . PHP_EOL;

$pizza2 = $chicagoStore->orderPizza('チーズ');
echo ('ジョエルの注文は' . $pizza2->getName()) . PHP_EOL;
