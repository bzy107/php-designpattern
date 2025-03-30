<?php

declare(strict_types=1);

abstract class Display
{
    abstract public function getColumns();

    abstract public function getRows();

    abstract public function getRowText(int $row);

    final public function show()
    {
        for ($i = 0; $i < $this->getRows(); $i++) {
            echo $this->getRowText($i) . PHP_EOL;
        }
    }
}

class StringDisplay extends Display
{
    private string $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function getColumns()
    {
        return strlen($this->string);
    }

    public function getRows()
    {
        return 1;
    }

    public function getRowText(int $row)
    {
        if ($row === 0) {
            return $this->string;
        }

        return null;
    }
}

abstract class Border extends Display
{
    protected $display;

    protected function __construct(Display $display)
    {
        $this->display = $display;
    }
}

class SideBorder extends Border
{
    private string $borderChar;

    public function __construct(Display $display, string $ch)
    {
        parent::__construct($display);
        $this->borderChar = $ch;
    }

    public function getColumns()
    {
        return 1 + $this->display->getColumns() + 1;
    }

    public function getRows()
    {
        return $this->display->getRows();
    }

    public function getRowText(int $row)
    {
        return $this->borderChar . $this->display->getRowText($row) . $this->borderChar;
    }
}

class FullBorder extends Border
{
    public function __construct(Display $display)
    {
        parent::__construct($display);
    }

    public function getColumns()
    {
        return 1 + $this->display->getColumns() + 1;
    }

    public function getRows()
    {
        return 1 + $this->display->getRows() + 1;
    }

    public function getRowText(int $row)
    {
        if ($row === 0) {
            return '+' . $this->makeLine('-', $this->display->getColumns()) . '+';
        } elseif ($row === $this->display->getRows() + 1) {
            return '+' . $this->makeLine('-', $this->display->getColumns()) . '+';
        }

        return '|' . $this->display->getRowText($row - 1) . '|';
    }

    private function makeLine(string $ch, int $count)
    {
        $str = '';
        for ($i = 0; $i < $count; $i++) {
            $str .= $ch;
        }

        return $str;
    }
}

$b1 = new StringDisplay('Hello, world!');
$b2 = new SideBorder($b1, '@');
$b3 = new FullBorder($b2);

$b1->show();
$b2->show();
$b3->show();

$b4 = new SideBorder(
    new FullBorder(
        new FullBorder(
            new SideBorder(
                new FullBorder(
                    new StringDisplay('こんにちは!')
                ),
                '*'
            )
        )
    ),
    '/'
);

$b4->show();
