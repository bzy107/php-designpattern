<?php

declare(strict_types=1);

class Trouble
{
    private int $number;
    public function __construct(int $number)
    {
        $this->number = $number;
    }

    public function __toString()
    {
        return "[Trouble $this->number ]";
    }

    public function getNumber()
    {
        return $this->number;
    }
}

abstract class Support
{
    private string $name;
    private ?Support $next = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    // public function __toString()
    // {
    //     return $this->name;
    // }

    public function setNext(Support $next)
    {
        $this->next = $next;
        return $next;
    }

    final public function support(Trouble $trouble)
    {
        if ($this->resolve($trouble)) {
            $this->done($trouble);
        } elseif ($this->next !== null) {
            $this->next->support($trouble);
        } 
        $this->fail($trouble);
    }

    public function __toString()
    {
        return "[$this->name]";
    }

    abstract protected function resolve(Trouble $trouble);

    protected function done(Trouble $trouble)
    {
        print("$trouble is resolved by $this.").PHP_EOL;
    }

    protected function fail(Trouble $trouble)
    {
        print("$trouble cannot be resolved.").PHP_EOL;
    }
}

class NoSupport extends Support
{
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    protected function resolve(Trouble $trouble)
    {
        return false;
    }
}

class LimitSupport extends Support
{
    private int $limit;

    public function __construct(string $name, int $limit)
    {
        parent::__construct($name);
        $this->limit = $limit;
    }

    protected function resolve(Trouble $trouble)
    {
        if ($trouble->getNumber() < $this->limit) {
            return true;
        } 
        return false;
    }
}

class OddSupport extends Support
{
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    protected function resolve(Trouble $trouble)
    {
        if ($trouble->getNumber() % 2 === 1) {
            return true;
        }
        return false;
    }
}


class SpecialSupport extends Support
{
    private int $number;

    public function __construct(string $name, int $number)
    {
        parent::__construct($name);
        $this->number = $number;
    }

    protected function resolve(Trouble $trouble)
    {
        if ($trouble->getNumber() === $this->number) {
            return true;
        }
        return false;
    }
}

$alice = new NoSupport("Alice");
$bob = new LimitSupport("Bob", 100);
$charlie = new SpecialSupport("Charlie", 429);
$diana = new LimitSupport("Diana", 200);
$elmo = new OddSupport("Elmo");
$fred = new LimitSupport("Fred", 300);

$alice->setNext($bob)->setNext($charlie)->setNext($diana)->setNext($elmo)->setNext($fred);
// $alice->setNext($bob);

for ($i=0; $i<500; $i+= 33) {
    $alice->support(new Trouble($i));
}

