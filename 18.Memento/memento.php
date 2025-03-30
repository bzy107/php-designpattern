<?php

declare(strict_types=1);

class Memento
{
    public function __construct(private State $state)
    {
    }

    public function getState()
    {
        return $this->state;
    }
}

class State implements \Stringable
{
    public const STATE_CREATED = 'created';

    public const STATE_OPENED = 'opened';

    public const STATE_ASSIGNED = 'assigned';

    public const STATE_CLOSED = 'closed';

    private string $state;

    private static array $validStates = [
        self::STATE_CREATED,
        self::STATE_OPENED,
        self::STATE_ASSIGNED,
        self::STATE_CLOSED,
    ];

    public function __construct(string $state)
    {
        self::ensureIsValidState($state);

        $this->state = $state;
    }

    private static function ensureIsValidState(string $state)
    {
        if (! in_array($state, self::$validStates)) {
            throw new InvalidArgumentException('Invalid stae given');
        }
    }

    public function __toString(): string
    {
        return $this->state;
    }
}

class Ticket
{
    private State $currentState;

    public function __construct()
    {
        $this->currentState = new State(State::STATE_CREATED);
    }

    public function open()
    {
        $this->currentState = new State(State::STATE_OPENED);
    }

    public function assign()
    {
        $this->currentState = new State(State::STATE_ASSIGNED);
    }

    public function close()
    {
        $this->currentState = new State(State::STATE_CLOSED);
    }

    public function saveToMemento(): Memento
    {
        return new Memento(clone $this->currentState);
    }

    public function restoreFromMemento(Memento $memento)
    {
        $this->currentState = $memento->getState();
    }

    public function getState(): State
    {
        return $this->currentState;
    }
}

$ticket = new Ticket();
$ticket->open();

$openedState = $ticket->getState();

echo $openedState . PHP_EOL;  // expected: opened

$mement = $ticket->saveToMemento();

echo ('memento state : ' . $mement->getState()) . PHP_EOL;

$ticket->assign();
echo $ticket->getState() . PHP_EOL; // expected: assigned

$ticket->restoreFromMemento($mement);
echo $ticket->getState() . PHP_EOL; // expected: opened

$result = $openedState === $ticket->getState();
if ($result) {
    echo 'true' . PHP_EOL;
} else {
    echo 'false' . PHP_EOL;
}
