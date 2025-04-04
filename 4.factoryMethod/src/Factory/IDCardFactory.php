<?php

namespace FactoryMethod\Factory;

class IDCardFactory extends Factory
{
    private array $owners = [];

    protected function createProduct(string $owner): IDCard
    {
        return new IDCard($owner);
    }

    protected function registerProduct(Product $product): void
    {
        $this->getOwners()[] = $product;
    }

    public function getOwners(): array
    {
        return $this->owners;
    }
}
