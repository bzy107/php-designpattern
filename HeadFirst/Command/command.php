<?php

declare(strict_types=1);


interface Command
{
    public function execute() : void;
}

class NoCommand implements Command
{
    public function execute(): void {}
}

class RemoteControl
{
    public function __construct(
        private array $onCommands = [],
        private array $offCommands = []
    )
    {
        $noCommand = new NoCommand();
        for ($i=0; $i<7; $i++) {
            $this->onCommands[$i] = $noCommand;
            $this->offCommands[$i] = $noCommand;
        }
    }

    public function setCommand(
        int $slot,
        Command $onCommand,
        Command $offCommand
    )
    {
        $this->onCommands[$slot] = $onCommand;
        $this->offCommands[$slot] = $offCommand;
    }

    public function onButtonWasPushed(int $slot)
    {
        $this->onCommands[$slot]->execute();
    }

    public function offButtonWasPushed(int $slot)
    {
        $this->offCommands[$slot]->execute();
    }

    public function toString()
    {
        print(PHP_EOL . "---------------リモコン-----------\n");
        for ($j=0; $j<count($this->onCommands); $j++) {
            print('スロット[' . $j . '] : ' . get_class($this->onCommands[$j]) . PHP_EOL);
        }
    }
}

class LightOnCommand implements Command
{
    public function __construct(private Light $light) {}

    public function execute() : void
    {
        $this->light->on();
    }
}

class LightOffCommand implements Command
{
    public function __construct(private Light $light) {}

    public function execute() : void
    {
        $this->light->off();
    }
}


class Light
{
    public function on() : void
    {
        print('Light On').PHP_EOL;
    }

    public function off() : void
    {
        print('Light Off').PHP_EOL;
    }
}

class Stereo
{
    public function on() : void
    {
        print('Stereo On').PHP_EOL;
    }

    public function setCD() : void
    {
        print('Stereo Set CD').PHP_EOL;
    }

    public function setVolume(int $volume) : void
    {
        print('Stereo Set Volume ' . $volume).PHP_EOL;
    }

    public function off() : void
    {
        print('Stereo Off').PHP_EOL;
    }
}

class StereoOnWithCDCommand implements Command
{
    public function __construct(private Stereo $stereo) {}

    public function execute(): void
    {
        $this->stereo->on();
        $this->stereo->setCD();
        $this->stereo->setVolume(11);
    }
}

class StereoOffWithCDCommand implements Command
{
    public function __construct(private Stereo $stereo) {}

    public function execute(): void
    {
        $this->stereo->off();
    }
}


$remoteControl = new RemoteControl();


$livingRoomLight =  new Light('リビングルーム');
$kitchenLight =  new Light('キッチン');
$stereo = new Stereo('リビングルーム');

$livingRoomLightOn = new LightOnCommand($livingRoomLight);
$livingRoomLightOff = new LightOffCommand($livingRoomLight);

$kitchenLightOn = new LightOnCommand($kitchenLight);
$kitchenLightOff = new LightOffCommand($kitchenLight);

$stereoOnWithCD = new StereoOnWithCDCommand($stereo);
$stereoOffWithCD = new StereoOffWithCDCommand($stereo);



$remoteControl->setCommand(0, $livingRoomLightOn, $livingRoomLightOff);
$remoteControl->setCommand(1, $kitchenLightOn, $kitchenLightOff);
$remoteControl->setCommand(2, $stereoOnWithCD, $stereoOffWithCD);

$remoteControl->toString();

$remoteControl->onButtonWasPushed(0);
$remoteControl->offButtonWasPushed(0);
$remoteControl->onButtonWasPushed(1);
$remoteControl->offButtonWasPushed(1);
$remoteControl->onButtonWasPushed(2);
$remoteControl->offButtonWasPushed(2);



















// class Light
// {
//     public function on()
//     {
//         print('light on').PHP_EOL;
//     }

//     public function off()
//     {
//         print('light off').PHP_EOL;
//     }
// }

// class SimpleRemoteControl
// {
//     private Command $slot;

//     public function setCommand(Command $command)
//     {
//         $this->slot = $command;
//     }

//     public function buttonWasPressed()
//     {
//         $this->slot->execute();
//     }
// }
// // {
// //     public function __construct(
// //         private $onCommands = new Command(),
// //         private $offCommands = new Command()
// //     )
// //     {
        
// //     }
// // }


// $remote = new SimpleRemoteControl();
// $light = new Light();
// $lightOn = new LightOnCommand($light);

// $remote->setCommand($lightOn);
// $remote->buttonWasPressed();
