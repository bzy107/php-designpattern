<?php

declare(strict_types=1);

interface Command
{
    public function execute() : void;
    public function undo() : void;
}


class NoCommand implements Command
{
    public function execute() : void {}
    public function undo() : void {}
}

class RemoteControlWithUndo
{
    public function __construct(
        private array $onCommands = [],
        private array $offCommands = [],
        private $undoCommand = null
    )
    {
        $noCommand = new NoCommand();
        for ($i=0; $i<7; $i++) {
            $this->onCommands[$i] = $noCommand;
            $this->offCommands[$i] = $noCommand;
        }
        $undoCommand = $noCommand;
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

    public function onButtonWasPushed(int $slot) : void
    {
        $this->onCommands[$slot]->execute();
        $this->undoCommand = $this->onCommands[$slot];
    }

    public function offButtonWasPushed(int $slot) : void
    {
        $this->offCommands[$slot]->execute();
        $this->undoCommand = $this->offCommands[$slot];
    }

    public function undoButtonWasPushed() : void
    {
        $this->undoCommand->undo();
    }

    public function toString() : void
    {
        print(PHP_EOL . "---------------リモコン-----------\n");
        for ($j=0; $j<count($this->onCommands); $j++) {
            print('スロット[' . $j . '] : ' . get_class($this->onCommands[$j]) 
                . '  ' . get_class($this->offCommands[$j]) . PHP_EOL);
        }
        if ($this->undoCommand) {
            Print('Undo: ' . get_class($this->undoCommand)).PHP_EOL;
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

    public function undo() : void
    {
        $this->light->off();
    }
}

class LightOffCommand implements Command
{
    public function __construct(private Light $light) {}

    public function execute() : void
    {
        $this->light->off();
    }

    public function undo() : void
    {
        $this->light->on();
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

class CeilingFan
{
    const HIGH = 3;
    const MEDIUM = 2;
    const LOW = 1;
    const OFF = 0;

    public function __construct(
        private string $location,
        private int $speed = self::HIGH
    ) {}

    public function high() : void
    {
        print('CeilingFan High').PHP_EOL;
        $this->speed = self::HIGH;
    }

    public function medium() : void
    {
        print('CeilingFan Medium').PHP_EOL;
        $this->speed = self::MEDIUM;
    }

    public function low() : void
    {
        print('CeilingFan Low').PHP_EOL;
        $this->speed = self::LOW;
    }

    public function off() : void
    {
        print('CeilingFan Off').PHP_EOL;
        $this->speed = self::OFF;
    }

    public function getSpeed() : int
    {
        return $this->speed;
    }
}

class CeilingFanHighCommand implements Command
{
    private int $prevSpeed;
    public function __construct(private CeilingFan $ceilingFan) {}

    public function execute() : void
    {
        $this->prevSpeed = $this->ceilingFan->getSpeed();
        $this->ceilingFan->high();
    }

    public function undo(): void
    {
        if ($this->prevSpeed === CeilingFan::HIGH) $this->ceilingFan->high();
        if ($this->prevSpeed === CeilingFan::MEDIUM) $this->ceilingFan->medium();
        if ($this->prevSpeed === CeilingFan::LOW) $this->ceilingFan->low();
        if ($this->prevSpeed === CeilingFan::OFF) $this->ceilingFan->off();
    }
}

class CeilingFanMediumCommand implements Command
{
    private int $prevSpeed;
    public function __construct(private CeilingFan $ceilingFan) {}

    public function execute() : void
    {
        $this->prevSpeed = $this->ceilingFan->getSpeed();
        $this->ceilingFan->medium();
    }

    public function undo(): void
    {
        if ($this->prevSpeed === CeilingFan::HIGH) $this->ceilingFan->high();
        if ($this->prevSpeed === CeilingFan::MEDIUM) $this->ceilingFan->medium();
        if ($this->prevSpeed === CeilingFan::LOW) $this->ceilingFan->low();
        if ($this->prevSpeed === CeilingFan::OFF) $this->ceilingFan->off();
    }
}

class CeilingFanOffCommand implements Command
{
    private int $prevSpeed;
    public function __construct(private CeilingFan $ceilingFan) {}

    public function execute() : void
    {
        $this->prevSpeed = $this->ceilingFan->getSpeed();
        $this->ceilingFan->off();
    }

    public function undo(): void
    {
        if ($this->prevSpeed === CeilingFan::HIGH) $this->ceilingFan->high();
        if ($this->prevSpeed === CeilingFan::MEDIUM) $this->ceilingFan->medium();
        if ($this->prevSpeed === CeilingFan::LOW) $this->ceilingFan->low();
        if ($this->prevSpeed === CeilingFan::OFF) $this->ceilingFan->off();
    }
}
class StereoOnWithCDCommand implements Command
{
    public function __construct(private Stereo $stereo) {}

    public function execute() : void
    {
        $this->stereo->on();
        $this->stereo->setCD();
        $this->stereo->setVolume(11);
    }

    public function undo() : void
    {
        $this->stereo->off();
    }
}

class StereoOffWithCDCommand implements Command
{
    public function __construct(private Stereo $stereo) {}

    public function execute() : void
    {
        $this->stereo->off();
    }

    public function undo() : void
    {
        $this->stereo->on();
        $this->stereo->setCD();
        $this->stereo->setVolume(11);
    }
}

class MacroCommand implements Command
{
    public function __construct(private array $command) {}

    public function execute() : void
    {
        for ((int)$i=0; $i<count($this->command); $i++) {
            $this->command[$i]->execute();
        }
    }

    public function undo(): void
    {
        for ((int)$j=0; $j<count($this->command); $j++) {
            $this->command[$j]->undo();
        }
    }
}

$remoteControl = new RemoteControlWithUndo();

$light = new Light('リビングルーム');
$stereo = new Stereo('リビングルーム');

$lightOn = new LightOnCommand($light);
$lightOff = new LightOffCommand($light);
$stereoOn = new StereoOnWithCDCommand($stereo);
$stereoOff = new StereoOffWithCDCommand($stereo);

$partyOn = [$lightOn, $stereoOn];
$partyOff = [$lightOff, $stereoOff];

$partyOnMacro = new MacroCommand($partyOn);
$partyOffMacro = new MacroCommand($partyOff);

$remoteControl->setCommand(0, $partyOnMacro, $partyOffMacro);

$remoteControl->toString();
print('--マクロのOnを押す--').PHP_EOL;
$remoteControl->onButtonWasPushed(0);
print('--マクロのOffを押す--').PHP_EOL;
$remoteControl->offButtonWasPushed(0);

print('--マクロのリドゥを押す--').PHP_EOL;
$remoteControl->undoButtonWasPushed();



// $livingRoomLight =  new Light('リビングルーム');
// $kitchenLight =  new Light('キッチン');
// $stereo = new Stereo('リビングルーム');

// $livingRoomLightOn = new LightOnCommand($livingRoomLight);
// $livingRoomLightOff = new LightOffCommand($livingRoomLight);

// $kitchenLightOn = new LightOnCommand($kitchenLight);
// $kitchenLightOff = new LightOffCommand($kitchenLight);

// $stereoOnWithCD = new StereoOnWithCDCommand($stereo);
// $stereoOffWithCD = new StereoOffWithCDCommand($stereo);



// ライトとステレオの実装
// $remoteControl->setCommand(0, $livingRoomLightOn, $livingRoomLightOff);
// $remoteControl->setCommand(1, $kitchenLightOn, $kitchenLightOff);
// $remoteControl->setCommand(2, $stereoOnWithCD, $stereoOffWithCD);

// $remoteControl->toString();

// $remoteControl->onButtonWasPushed(0);
// $remoteControl->offButtonWasPushed(0);
// $remoteControl->onButtonWasPushed(1);
// $remoteControl->offButtonWasPushed(1);
// $remoteControl->onButtonWasPushed(2);
// $remoteControl->offButtonWasPushed(2);


// アンドゥの実装確認
// $remoteControl->setCommand(0, $livingRoomLightOn, $livingRoomLightOff);
// $remoteControl->onButtonWasPushed(0);
// $remoteControl->offButtonWasPushed(0);
// $remoteControl->toString();
// $remoteControl->undoButtonWasPushed();
// $remoteControl->offButtonWasPushed(0);
// $remoteControl->onButtonWasPushed(0);
// $remoteControl->toString();
// $remoteControl->undoButtonWasPushed();

// シーリングファンクラスの確認
// $ceilingFan = new CeilingFan('リビングルーム');

// $ceilingFanMedium = new CeilingFanMediumCommand($ceilingFan);
// $ceilingFanHigh = new CeilingFanHighCommand($ceilingFan);
// $ceilingFanOff = new CeilingFanOffCommand($ceilingFan);

// $remoteControl->setCommand(0, $ceilingFanMedium, $ceilingFanOff);
// $remoteControl->setCommand(1, $ceilingFanHigh, $ceilingFanOff);

// $remoteControl->onButtonWasPushed(0);
// $remoteControl->offButtonWasPushed(0);
// $remoteControl->toString();

// $remoteControl->undoButtonWasPushed();

// $remoteControl->onButtonWasPushed(1);
// $remoteControl->toString();
// $remoteControl->undoButtonWasPushed();













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
