<?php

abstract class Product
{
    abstract public function use(): void;
}

abstract class Factory
{
    final public function create(string $own) : Product
    {
        $p = $this->createProduct($own);
        $this->registerProduct($p);
        return $p;
    }

    abstract protected function createProduct(string $own) : Product;
    abstract protected function registerProduct(Product $product);
}

class IDCard extends Product
{
    private string $owner;
    public function __construct(string $owner)
    {
        print($owner . ' のカードを作ります').PHP_EOL;
        $this->owner = $owner;
    }

    public function use() : void
    {
        print($this->owner . ' のカードを使います').PHP_EOL;
    }

    public function getOwner()
    {
        return $this->owner;
    }
}

class IDCardFactory extends Factory
{
    private array $owners = [];
    protected function createProduct(string $owner) : IDCard
    {
        return new IDCard($owner);
    }

    protected function registerProduct(Product $product)
    {
        array_push($this->owners, $product);
    }

    public function getOwners() : array
    {
        return $this->owners;
    }
}


$factory = new IDCardFactory();
$card1 = $factory->create('test user');
$card2 = $factory->create('test user2');
$card3 = $factory->create('test user3');

$card1->use();
$card2->use();
$card3->use();


print($card1->getOwner()).PHP_EOL;
