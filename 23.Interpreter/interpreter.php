<?php

declare(strict_types=1);

abstract class AbstractExp
{
    abstract public function interpret(Context $context): bool;
}

class Context
{
    private array $poolVariable;

    public function lookUp(string $name): bool
    {
        if (! array_key_exists($name, $this->poolVariable)) {
            throw new Exception("no exist variable: $name");
        }

        return $this->poolVariable[$name];
    }

    public function assign(VariableExp $variable, bool $val)
    {
        $this->poolVariable[$variable->getName()] = $val;
    }
}

class VariableExp extends AbstractExp
{
    public function __construct(private string $name)
    {
    }

    public function interpret(Context $context): bool
    {
        return $context->lookUp($this->name);
    }

    public function getName(): string
    {
        return $this->name;
    }
}

class AndExp extends AbstractExp
{
    public function __construct(private AbstractExp $first, private AbstractExp $second)
    {
    }

    public function interpret(Context $context): bool
    {
        return $this->first->interpret($context) && $this->second->interpret($context);
    }
}

class OrExp extends AbstractExp
{
    public function __construct(private AbstractExp $first, private AbstractExp $second)
    {
    }

    public function interpret(Context $context): bool
    {
        return $this->first->interpret($context) || $this->second->interpret($context);
    }
}

$context = new Context();
$a = new VariableExp('A');
$b = new VariableExp('B');
$c = new VariableExp('C');

$context->assign($a, false);
$context->assign($b, false);
$context->assign($c, true);

$exp1 = new OrExp($a, $b);
$result1 = $exp1->interpret($context);

echo $result1 . PHP_EOL;

$exp2 = new OrExp($exp1, $c);
$result2 = $exp2->interpret($context);

echo $result2 . PHP_EOL;

$d = new VariableExp('D');
$e = new VariableExp('E');
$f = new VariableExp('F');

$context->assign($d, true);
$context->assign($e, true);
$context->assign($f, false);

$exp3 = new AndExp($d, $e);
$result3 = $exp3->interpret($context);

echo $result3 . PHP_EOL;

$exp4 = new AndExp($exp3, $f);
$result4 = $exp4->interpret($context);

echo $result4 . PHP_EOL;
