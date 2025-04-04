<?php

namespace FactoryMethod\FactoryMethod\Factory;

use FactoryMethod\FactoryMethod\Factory\Product;


class IDCard extends Product
{
    public function __construct(private string $owner)
    {
    }

    public function use(): string
    {
        return 'use card for ' . $this->owner;
    }

    public function getOwner(): string
    {
        return $this->owner;
    }
}
