<?php

declare(strict_types=1);

class Plactice
{
    public function nullCoalescingOperator(?string $arg): string
    {
        // null合体演算子 nullの場合かどうかで場合分け
        return $arg ?? 'this is null';
    }

    public function ternaryOperator(string $arg): string
    {
        return $arg === 'test' ? 'this is test!!' : 'this is production!!';
    }
}

$plactice = new Plactice();

echo $plactice->nullCoalescingOperator(null) . PHP_EOL;

echo $plactice->ternaryOperator('tests') . PHP_EOL;
