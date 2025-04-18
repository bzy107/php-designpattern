<?php

declare(strict_types=1);

interface Duck
{
    public function quack(): void;

    public function fly(): void;
}

class MallardDuck implements Duck
{
    public function quack(): void
    {
        echo 'ガーガー' . PHP_EOL;
    }

    public function fly(): void
    {
        echo '飛んでいます' . PHP_EOL;
    }
}

/**
 * Adaptee
 */
interface Turkey
{
    public function gobble(): void;

    public function fly(): void;
}

class WildTurkey implements Turkey
{
    public function gobble(): void
    {
        echo 'ゴロゴロ' . PHP_EOL;
    }

    public function fly(): void
    {
        echo '短い距離を飛びます' . PHP_EOL;
    }
}

/**
 * Adapter
 */
class TurkeyAdapter implements Duck
{
    public function __construct(private Turkey $turkey)
    {
    }

    public function quack(): void
    {
        $this->turkey->gobble();
    }

    public function fly(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->turkey->fly();
        }
    }
}

// action code
class DuckTestDrive
{
    public function main(): void
    {
        $duck = new MallardDuck();
        $turkey = new WildTurkey();
        $turkeyAdapter = new TurkeyAdapter($turkey);

        echo "\n--Turkey OUTPUT--" . PHP_EOL;
        $turkey->gobble();
        $turkey->fly();

        echo "\n--Duck OUTPUT--" . PHP_EOL;
        $this->testDuck($duck);

        echo "\n--TurkeyAdapter--" . PHP_EOL;
        $this->testDuck($turkeyAdapter);
    }

    public function testDuck(Duck $duck)
    {
        $duck->quack();
        $duck->fly();
    }
}

(new DuckTestDrive())->main();
