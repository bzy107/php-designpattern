<?php

declare(strict_types=1);

interface PizzaIngredientFactory
{
    public function createDough();

    public function createSauce();

    public function createCheese();

    public function createVeggies();

    public function createPepperoni();

    public function createClam();
}

class NYPizzaIngredientFactory implements PizzaIngredientFactory
{
    public function createDough(): Dough
    {
        return new ThinCrustDough();
    }

    public function createSauce(): Sauce
    {
        return new MarinaraSauce();
    }

    public function createCheese()
    {
        return new ReggianoCheese();
    }

    public function createVeggies()
    {
        return [new Garlic(), new Onion(), new Mushroom(), new RedPepper()];
    }

    public function createPepperoni()
    {
        return new SlicedPepperoni();
    }

    public function createClam()
    {
        return new FreshClams();
    }
}

class ChicagoPizzaIngredientFactory implements PizzaIngredientFactory
{
    public function createDough(): Dough
    {
        return new ThinCrustDough();
    }

    public function createSauce(): Sauce
    {
        return new MarinaraSauce();
    }

    public function createCheese()
    {
        return new ReggianoCheese();
    }

    public function createVeggies()
    {
        return [new Garlic(), new Onion(), new Mushroom(), new RedPepper()];
    }

    public function createPepperoni()
    {
        return new SlicedPepperoni();
    }

    public function createClam()
    {
        return new FreshClams();
    }
}

abstract class Pizza
{
    protected string $name;

    protected $dough;

    protected $veggies;

    protected $cheese;

    protected $pepperoni;

    protected $clam;

    abstract protected function prepare();

    final public function bake()
    {
        echo '180度で25分間焼く' . PHP_EOL;
    }

    final public function cut()
    {
        echo 'ピザを扇形にカットする' . PHP_EOL;
    }

    final public function box()
    {
        echo 'PizzaStoreの箱にピザを入れる' . PHP_EOL;
    }

    final public function setName(string $name)
    {
        $this->name = $name;
    }

    final public function getName()
    {
        return $this->name;
    }
}

class CheesePizza extends Pizza
{
    protected PizzaIngredientFactory $ingredientFactory;

    public function __construct(PizzaIngredientFactory $ingredientFactory)
    {
        $this->ingredientFactory = $ingredientFactory;
    }

    public function prepare()
    {
        echo ($this->name . 'を下準備') . PHP_EOL;
        $this->dough = $this->ingredientFactory->createDough();
        $this->sauce = $this->ingredientFactory->createSauce();
        $this->cheese = $this->ingredientFactory->createCheese();
    }
}

class ClamPizza extends Pizza
{
    protected PizzaIngredientFactory $ingredientFactory;

    public function __construct(PizzaIngredientFactory $ingredientFactory)
    {
        $this->ingredientFactory = $ingredientFactory;
    }

    public function prepare()
    {
        echo ($this->name . 'を下準備') . PHP_EOL;
        $this->dough = $this->ingredientFactory->createDough();
        $this->sauce = $this->ingredientFactory->createSauce();
        $this->cheese = $this->ingredientFactory->createCheese();
        $this->clam = $this->ingredientFactory->createClam();
    }
}

class VeggiePizza extends Pizza
{
    protected PizzaIngredientFactory $ingredientFactory;

    public function __construct(PizzaIngredientFactory $ingredientFactory)
    {
        $this->ingredientFactory = $ingredientFactory;
    }

    public function prepare()
    {
        echo ($this->name . 'を下準備') . PHP_EOL;
        $this->dough = $this->ingredientFactory->createDough();
        $this->sauce = $this->ingredientFactory->createSauce();
        $this->cheese = $this->ingredientFactory->createCheese();
        $this->veggies = $this->ingredientFactory->createVeggies();
    }
}

class PepperoniPizza extends Pizza
{
    protected PizzaIngredientFactory $ingredientFactory;

    public function __construct(PizzaIngredientFactory $ingredientFactory)
    {
        $this->ingredientFactory = $ingredientFactory;
    }

    public function prepare()
    {
        echo ($this->name . 'を下準備') . PHP_EOL;
        $this->dough = $this->ingredientFactory->createDough();
        $this->sauce = $this->ingredientFactory->createSauce();
        $this->cheese = $this->ingredientFactory->createCheese();
        $this->veggies = $this->ingredientFactory->createVeggies();
        $this->pepperoni = $this->ingredientFactory->createPepperoni();
    }
}

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

    abstract protected function createPizza(string $type);
}

class NYPizzaStore extends PizzaStore
{
    public function createPizza(string $type)
    {
        $pizza = null;
        $ingredientFactory = new NYPizzaIngredientFactory();

        if ($type === 'チーズ') {
            $pizza = new CheesePizza($ingredientFactory);
            $pizza->setName('ニューヨークスタイルチーズピザ');
        } elseif ($type === '野菜') {
            $pizza = new VeggiePizza($ingredientFactory);
            $pizza->setName('ニューヨークスタイル野菜ピザ');
        } elseif ($type === 'アサリ') {
            $pizza = new ClamPizza($ingredientFactory);
            $pizza->setName('ニューヨークスタイルアサリピザ');
        } elseif ($type === 'ぺパニロ') {
            $pizza = new PepperoniPizza($ingredientFactory);
            $pizza->setName('ニューヨークスタイルペパロニピザ');
        }

        return $pizza;
    }
}

class ChicagoPizzaStore extends PizzaStore
{
    public function createPizza(string $type)
    {
        $pizza = null;
        $ingredientFactory = new ChicagoPizzaIngredientFactory();

        if ($type === 'チーズ') {
            $pizza = new CheesePizza($ingredientFactory);
            $pizza->setName('シカゴスタイルチーズピザ');
        } elseif ($type === '野菜') {
            $pizza = new VeggiePizza($ingredientFactory);
            $pizza->setName('シカゴスタイル野菜ピザ');
        } elseif ($type === 'アサリ') {
            $pizza = new ClamPizza($ingredientFactory);
            $pizza->setName('シカゴスタイルアサリピザ');
        } elseif ($type === 'ぺパニロ') {
            $pizza = new PepperoniPizza($ingredientFactory);
            $pizza->setName('シカゴスタイルペパロニピザ');
        }

        return $pizza;
    }
}

interface Dough
{
    public function toString(): string;
}

class ThinCrustDough implements Dough
{
    public function toString(): string
    {
        return 'Thin Crust Dough';
    }
}

interface Sauce
{
    public function toString(): string;
}

class MarinaraSauce implements Sauce
{
    public function toString(): string
    {
        return 'Marinara Sauce';
    }
}

interface Cheese
{
    public function toString(): string;
}

class ReggianoCheese implements Cheese
{
    public function toString(): string
    {
        return 'Reggiano Cheese';
    }
}

interface Veggies
{
    public function toString(): string;
}

class Garlic implements Veggies
{
    public function toString(): string
    {
        return 'Garlic';
    }
}

class Onion implements Veggies
{
    public function toString(): string
    {
        return 'Onion';
    }
}

class Mushroom implements Veggies
{
    public function toString(): string
    {
        return 'Mushroom';
    }
}

class RedPepper implements Veggies
{
    public function toString(): string
    {
        return 'RedPepper';
    }
}

interface Pepperoni
{
    public function toString(): string;
}

class SlicedPepperoni implements Pepperoni
{
    public function toString(): string
    {
        return 'Sliced Pepperoni';
    }
}

interface Clams
{
    public function toString(): string;
}

class FreshClams implements Clams
{
    public function toString(): string
    {
        return 'Fresh Clams from Long Island Sound';
    }
}

$nyPizzStore = new NYPizzaStore();
$ny = $nyPizzStore->orderPizza('チーズ');
echo $ny->getName() . PHP_EOL;

$chicagoPizzStore = new ChicagoPizzaStore();
$ch = $chicagoPizzStore->orderPizza('チーズ');
echo $ch->getName() . PHP_EOL;
