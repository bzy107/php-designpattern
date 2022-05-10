<?php

declare(strict_types=1);


interface Command
{
    public function execute();
}

interface UndoableCommand extends Command
{
    public function undo();
}

class HelloCommand implements Command
{
    public function __construct(private Receiver $output)
    {
    }

    public function execute()
    {
        $this->output->write('Hello World');
    }
}

class AddMessageDateCommand implements UndoableCommand
{
    public function __construct(private Receiver $output)
    {
    }

    public function execute()
    {
        $this->output->enableDate();
    }

    public function undo()
    {
        $this->output->disableDate();
    }
}



class Receiver
{
    private bool $enableDate = false;
    private array $output = [];

    public function write(string $str)
    {
        if ($this->enableDate) {
            $str .= ' [' . date('Y-m-d') . ']';
        }

        $this->output[] = $str;
    }

    public function getOutput() : string
    {
        return join('\n', $this->output);
    }

    public function enableDate()
    {
        $this->enableDate = true;
    }

    public function disableDate()
    {
        $this->enableDate = false;
    }
}

class Invoker
{
    private Command $command;

    public function setCommand(Command $command)
    {
        $this->command = $command;
    }

    public function run()
    {
        $this->command->execute();
    }
}


$invoker = new Invoker();
$receiver = new Receiver();

$invoker->setCommand(new HelloCommand($receiver));
$invoker->run();
print($receiver->getOutput()).PHP_EOL;





$invoker2 = new Invoker();
$receiver2 = new Receiver();

$invoker2->setCommand(new HelloCommand($receiver2));
$invoker2->run();
print($receiver2->getOutput());





$messageDateCommand = new AddMessageDateCommand($receiver2);
$messageDateCommand->execute();

$invoker2->run();
print($receiver2->getOutput()).PHP_EOL;

$messageDateCommand->undo();
$invoker2->run();

print($receiver2->getOutput()).PHP_EOL;
