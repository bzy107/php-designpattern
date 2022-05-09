<?php

declare(strict_types=1);

interface Text
{
    public function render(string $extrinsicState) : string;
}

class Word implements Text
{
    public function __construct(private string $name)
    {
    }

    public function render(string $extrinsicState) : string
    {
        return sprintf('Word %s with font %s', $this->name, $extrinsicState);
    }
}

class Character implements Text
{
    public function __construct(private string $name)
    {
    }

    public function render(string $extrinsicState) : string
    {
        return sprintf('Character %s with font %s', $this->name, $extrinsicState);
    }
}

class TextFactory implements Countable
{
    private array $charPool = [];

    public function get(string $name) : Text
    {
        if (!isset($this->charPool[$name])) {
            $this->charPool[$name] = $this->create($name);
        }

        return $this->charPool[$name];
    }

    private function create(string $name) : Text
    {
        if (strlen($name) === 1) {
            return new Character($name);
        } else {
            return new Word($name);
        }
    }

    public function count() : int
    {
        return count($this->charPool);
    }
}



$characters = [
    'a',
    'b',
    'c',
    'd',
    'e',
    'f',
    'g',
    'h',
    'i',
    'j',
    'k',
    'l',
    'm',
    'n',
    'o',
    'p',
    'q',
    'r',
    's',
    't',
    'u',
    'v',
    'w',
    'x',
    'y',
    'z',
];

$fonts = ['Arial', 'Times New Roman', 'Verdana', 'Helvetica'];


$factory = new TextFactory();
for ($i=0; $i<=10; $i++) {
    foreach ($characters as $c) {
        foreach ($fonts as $f) {
            $flyweight = $factory->get($c);
            $renderd = $flyweight->render($f);

            print($renderd).PHP_EOL;
        }
    }
}

foreach ($fonts as $fs) {
    $flyweight = $factory->get($fs);
    $renderd = $flyweight->render('foobar');

    print($renderd).PHP_EOL;
}

print(count($characters) + count($fonts)).PHP_EOL;
print($factory->count()).PHP_EOL;







