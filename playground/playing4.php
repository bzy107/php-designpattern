<?php

declare(strict_types=1);

final class ImmutablePrice
{
    /**
     * readonlyプロパティをつける場合はconstructorの中での代入が要らなくらるらしい！便利！
     */
    public function __construct(
        private readonly string $amount,
        private readonly int $price
    ) {
        if ($price < 0) {
            throw new RangeException('is not minus');
        }
        // $this->amount = $amount;
        // $this->price = $price;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getAmount(): string
    {
        $this->amount = 'CHANGE';

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
echo ($price->getPrice() . $price->getAmount()) . PHP_EOL;

$addedPrice = $price->addPrice(500);
echo ($addedPrice->getPrice() . $addedPrice->getAmount()) . PHP_EOL;

// $addedPrice->amount = 'JP_YEN';
// print($addedPrice->amount).PHP_EOL;
