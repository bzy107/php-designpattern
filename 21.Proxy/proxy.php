<?php

declare(strict_types=1);

interface Printable
{
    public function setPrinterName(string $name) : void;
    public function getPrinterName() : string;
    public function prints(string $string) : void;
}

class Printer implements Printable
{
    public function __construct(private string $name)
    {
        $this->name = $name;
        $this->heavyJob('Creating Printer instance ' . $this->name . '...');
    }

    public function setPrinterName(string $name): void
    {
        $this->name = $name;
    }

    public function getPrinterName(): string
    {
        return $this->name;
    }

    public function prints(string $string) : void
    {
        print('=== ' . $this->name . ' ===').PHP_EOL;
        print($string).PHP_EOL;
    }

    private function heavyJob(string $msg)
    {
        print($msg);
        for ($i=0; $i<5; $i++) {
            try {
                sleep(1);
            } catch (Exception $e) {
                print('error : ' . $e->getMessage());
            }
            print('.');
        }
        print('complete!').PHP_EOL;
    }
}

class PrinterProxy implements Printable
{
    private ?Printer $real;

    public function __construct(private string $name)
    {
        $this->name = $name;
        $this->real = null;
    }

    public function setPrinterName(string $name): void
    {
        if ($this->real !== null) {
            $this->real->setPrinterName($name);
        }
        $this->name = $name;
    }

    public function getPrinterName(): string
    {
        return $this->name;
    }

    public function prints(string $string) : void
    {
        $this->realize();
        $this->real->prints($string);
    }

    private function realize()
    {
        if ($this->real === null) {
            $this->real = new Printer($this->name);
        }
    }
}


$p = new PrinterProxy('Alice');

print('This name is ' . $p->getPrinterName() . '.').PHP_EOL;
$p->setPrinterName('Bob');
print('This name is ' . $p->getPrinterName() . '.').PHP_EOL;
$p->prints('hello world');