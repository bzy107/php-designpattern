<?php

declare(strict_types=1);

class OrderContext
{
    private Statesss $state;

    public static function create() : OrderContext
    {
        $order = new self();
        $order->state = new StateCreated();

        return $order;
    }

    public function setState(Statesss $state)
    {
        $this->state = $state;
    }

    public function proceedToNext()
    {
        $this->state->proceedToNext($this);
    }

    public function toString()
    {
        return $this->state->toString();
    }
}

interface Statesss
{
    public function proceedToNext(OrderContext $context);

    public function toString() : string;
}

class StateCreated implements Statesss
{
    public function proceedToNext(OrderContext $context)
    {
        $context->setState(new StateShipped());
    }

    public function toString() : string
    {
        return 'created';
    }
}

class StateShipped implements Statesss
{
    public function proceedToNext(OrderContext $context)
    {
        $context->setState(new StateDone());
    }

    public function toString() : string
    {
        return 'shipped';
    }
}

class StateDone implements Statesss
{
    public function proceedToNext(OrderContext $context)
    {
        // nothing to do;
    }

    public function toString(): string
    {
        return 'done';
    }
}

$createContext = OrderContext::create();
print($createContext->toString()).PHP_EOL; // expected created

$shippedContext = OrderContext::create();
$shippedContext->proceedToNext();
print($shippedContext->toString()).PHP_EOL; // expected shipped


$doneContext = OrderContext::create();
$doneContext->proceedToNext();
$doneContext->proceedToNext();
print($doneContext->toString()).PHP_EOL; // expected done


$donedoneContext = OrderContext::create();
$donedoneContext->proceedToNext();
$donedoneContext->proceedToNext();
print($donedoneContext->toString()).PHP_EOL; // expected done


