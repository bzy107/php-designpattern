<?php

declare(strict_types=1);

class HomeTheaterFacade
{
    public function __construct(
        private Amplifier $amp,
        private Tuner $tuner,
        private StreamingPlayer $player,
        private Projector $projector,
        private Screen $screen,
        private TheaterLights $lights,
        private PopcornPopper $popper
    ) {}

    public function watchMovie(string $movie)
    {
        print('映画を見る準備をします').PHP_EOL;
        $this->popper->on();
        $this->popper->pop();
        $this->lights->dim(10);
        $this->screen->down();
        $this->projector->on();
        $this->projector->wideScreenMode();
        $this->amp->on();
        $this->amp->setStreamingPlayer($this->player);
        $this->amp->setSurroundSound();
        $this->amp->setVolume(5);
        $this->player->on();
        $this->player->play($movie);
    }

    public function endMovie()
    {
        print('ムービーシアターを停止します').PHP_EOL;
        $this->popper->off();
        $this->lights->on();
        $this->screen->up();
        $this->projector->off();
        $this->amp->off();
        $this->player->stop();
        $this->player->off();
    }
}

class HomeTheaterTestDrive
{
    public function main()
    {
        $homeTheater = new HomeTheaterFacade(
            new Amplifier(), 
            new Tuner(), 
            new StreamingPlayer(), 
            new Projector(), 
            new Screen(), 
            new Theaterlights(), 
            new PopcornPopper(),
        );

        $homeTheater->watchMovie('レイダース/失われたアーク');
        $homeTheater->endMovie();
    }
}

class Amplifier
{
    private array $queue = [];
    public function on()
    {
        print('アンプをスイッチオン').PHP_EOL;
    }

    public function off()
    {
        print('アンプをスイッチオフ').PHP_EOL;
    }

    public function setStreamingPlayer($player)
    {
        print('アンプをストリーミングプレイヤーに設定').PHP_EOL;
    }

    public function setStereoSound()
    {
        print('アンプをステレオサウンドに設定').PHP_EOL;
    }

    public function setSurroundSound()
    {
        print('アンプをサラウンドサウンドをスイッチオン').PHP_EOL;
    }

    public function setTuner()
    {
        print('アンプをチューナーに設定').PHP_EOL;
    }

    public function setVolume(int $number)
    {
        print('アンプの音量を' . $number . 'に設定').PHP_EOL;
    }
}

class Tuner
{
    private $queue = [];
    public function on()
    {
        print('').PHP_EOL;
    }

    public function off()
    {
        print('').PHP_EOL;
    }

    public function setAm()
    {
        print('').PHP_EOL;
    }

    public function setFm()
    {
        print('').PHP_EOL;
    }

    public function setFrequency()
    {
        print('').PHP_EOL;
    }
}

class StreamingPlayer
{
    private string $movie;
    public function on()
    {
        print('ストリーミングプレーヤーをスイッチオン').PHP_EOL;
    }

    public function off()
    {
        print('ストリーミングプレーヤーをスイッチオフ').PHP_EOL;
    }

    public function pause()
    {
        print('ストリーミングプレーヤーを一時停止').PHP_EOL;
    }

    public function play($movie)
    {
        $this->movie = $movie;
        print('ストリーミングプレーヤーは「' . $movie . '」を再生').PHP_EOL;
    }

    public function setSurroundAudio()
    {
        print('ストリーミングプレーヤーのサラウンドをスイッチオン').PHP_EOL;
    }

    public function setTwoChannelAudio()
    {
        print('ストリーミングプレーヤーを２チャンネル設定').PHP_EOL;
    }

    public function dio()
    {
        print('ストリーミングプレーヤーを').PHP_EOL;
    }

    public function stop()
    {
        print('ストリーミングプレーヤーは「' . $this->movie . '」を停止').PHP_EOL;
    }
}

class Projector
{
    public function on()
    {
        print('プロジェクターをスイッチオン').PHP_EOL;
    }

    public function off()
    {
        print('プロジェクターをスイッチオフ').PHP_EOL;
    }

    public function tvMode()
    {
        print('プロジェクターはテレビモードです').PHP_EOL;
    }

    public function wideScreenMode()
    {
        print('プロジェクターはワイドスクリーンモードです').PHP_EOL;
    }
}

class Screen
{
    public function up()
    {
        print('シアターのスクリーンを上げます').PHP_EOL;
    }

    public function down()
    {
        print('シアターのスクリーンを下ろします').PHP_EOL;
    }
}

class TheaterLights
{
    public function on()
    {
        print('シアターの天井照明をスイッチオン').PHP_EOL;
    }

    public function off()
    {
        print('シアターの天井照明をスイッチオフ').PHP_EOL;
    }

    public function dim(int $number)
    {
        print('シアターの天井照明を'. $number . '%まで暗くします').PHP_EOL;
    }
}

class PopcornPopper
{
    public function on()
    {
        print('ポップコーンメーカーのスイッチオン').PHP_EOL;
    }

    public function off()
    {
        print('ポップコーンメーカーのスイッチオフ').PHP_EOL;
    }

    public function pop()
    {
        print('ポップコーンメーカーがポップコーンを作っています').PHP_EOL;
    }
}



(new HomeTheaterTestDrive())->main();
