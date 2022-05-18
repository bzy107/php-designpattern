<?php

declare(strict_types=1);


final class ImmutablePrice
{
    public function __construct(private string $amount, private int $price)
    {
        if ($price < 0) throw new RangeException('is not minus');
        $this->amount = $amount;
        $this->price = $price;
    }

    public function getPrice() : int
    {
        return $this->price;
    }

    public function getAmount() : string
    {
        return $this->amount;
    }

    /**
     * イミュータブルだが値段を追加できる例
     * self で自分自身のインスタンスを新たに生成して返しているのが味噌
     */
    public function addPrice(int $addPrice)
    {
        return new self($this->amount, $this->price + $addPrice);
    }
}

$price = new ImmutablePrice('USD', 100);
print($price->getPrice() . $price->getAmount()).PHP_EOL;

$addedPrice = $price->addPrice(-500);
print($addedPrice->getPrice() . $addedPrice->getAmount()).PHP_EOL;



