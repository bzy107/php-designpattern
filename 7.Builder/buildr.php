<?php

declare(strict_types=1);

abstract class Builder
{
    abstract public function makeTitle(string $title);

    abstract public function makeString(string $str);

    abstract public function makeItems(array $items);

    abstract public function close();
}

class Director
{
    private Builder $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function constructor(): void
    {
        $this->builder->makeTitle('Greet');
        $this->builder->makeString('朝から昼にかけて');
        $this->builder->makeItems(['Greet', 'Hello']);

        $this->builder->makeString('夜に');
        $this->builder->makeItems(['good night', 'goodby', 'bey']);

        $this->builder->close();
    }
}

class TextBuilder extends Builder
{
    private array $textArray = [];

    public function makeTitle(string $title): void
    {
        array_push($this->textArray, '=====================' . PHP_EOL);
        array_push($this->textArray, $title);
        array_push($this->textArray, PHP_EOL);
    }

    public function makeString(string $str): void
    {
        array_push($this->textArray, '■ ' . $str . PHP_EOL);
    }

    public function makeItems(array $items): void
    {
        foreach ($items as $item) {
            array_push($this->textArray, $item);
        }
    }

    public function close(): void
    {
        array_push($this->textArray, '======================' . PHP_EOL);
    }

    public function getResult(): string
    {
        return $this->arraytoString($this->textArray);
    }

    public function arraytoString($arr): string
    {
        $str = '';
        foreach ($arr as $a) {
            $str .= $a . PHP_EOL;
        }

        return $str;
    }
}

class HtmlBuilder extends Builder
{
    private array $textArray = [];

    public function makeTitle(string $title): void
    {
        array_push($this->textArray, '<html>' . PHP_EOL);
        array_push($this->textArray, $title);
        array_push($this->textArray, PHP_EOL);
    }

    public function makeString(string $str): void
    {
        array_push($this->textArray, '■ ' . $str . PHP_EOL);
    }

    public function makeItems(array $items): void
    {
        foreach ($items as $item) {
            array_push($this->textArray, $item);
        }
    }

    public function close(): void
    {
        array_push($this->textArray, '</html>' . PHP_EOL);
    }

    public function getResult(): string
    {
        return $this->arraytoString($this->textArray);
    }

    public function arraytoString($arr): string
    {
        $str = '';
        foreach ($arr as $a) {
            $str .= $a . PHP_EOL;
        }

        return $str;
    }
}

$textBuilder = new TextBuilder();
$director = new Director($textBuilder);
$director->constructor();

$result = $textBuilder->getResult();
echo $result;
