<?php

declare(strict_types=1);

/**
 * 継承を使ったパターン
 *
 * 既存のshowWithAster, showWithParen を変更せずに使用
 * version2などで追加機能などがある場合に既存のshowWithAster, showWithParenを使用したい場合に
 * そのまま使用できるようにしたもの
 */
interface Prints
{
    public function printWeak();

    public function printStrong();
}

class Banner
{
    public string $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function showWithParen()
    {
        echo ('(' . $this->string . ')') . PHP_EOL;
    }

    public function showWithAster()
    {
        echo ('*' . $this->string . '*') . PHP_EOL;
    }
}

class PrintBanner extends Banner implements Prints
{
    public function printWeak()
    {
        parent::showWithParen();
    }

    public function printStrong()
    {
        parent::showWithAster();
    }
}

$pr = new PrintBanner('aaaaa');
$pr->printWeak();
$pr->printStrong();
