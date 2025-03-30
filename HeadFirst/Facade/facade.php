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
    ) {
    }

    public function watchMovie(string $movie)
    {
        echo '映画を見る準備をします' . PHP_EOL;
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
        echo 'ムービーシアターを停止します' . PHP_EOL;
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
        echo 'アンプをスイッチオン' . PHP_EOL;
    }

    public function off()
    {
        echo 'アンプをスイッチオフ' . PHP_EOL;
    }

    public function setStreamingPlayer($player)
    {
        echo 'アンプをストリーミングプレイヤーに設定' . PHP_EOL;
    }

    public function setStereoSound()
    {
        echo 'アンプをステレオサウンドに設定' . PHP_EOL;
    }

    public function setSurroundSound()
    {
        echo 'アンプをサラウンドサウンドをスイッチオン' . PHP_EOL;
    }

    public function setTuner()
    {
        echo 'アンプをチューナーに設定' . PHP_EOL;
    }

    public function setVolume(int $number)
    {
        echo ('アンプの音量を' . $number . 'に設定') . PHP_EOL;
    }
}

class Tuner
{
    private $queue = [];

    public function on()
    {
        echo '' . PHP_EOL;
    }

    public function off()
    {
        echo '' . PHP_EOL;
    }

    public function setAm()
    {
        echo '' . PHP_EOL;
    }

    public function setFm()
    {
        echo '' . PHP_EOL;
    }

    public function setFrequency()
    {
        echo '' . PHP_EOL;
    }
}

class StreamingPlayer
{
    private string $movie;

    public function on()
    {
        echo 'ストリーミングプレーヤーをスイッチオン' . PHP_EOL;
    }

    public function off()
    {
        echo 'ストリーミングプレーヤーをスイッチオフ' . PHP_EOL;
    }

    public function pause()
    {
        echo 'ストリーミングプレーヤーを一時停止' . PHP_EOL;
    }

    public function play($movie)
    {
        $this->movie = $movie;
        echo ('ストリーミングプレーヤーは「' . $movie . '」を再生') . PHP_EOL;
    }

    public function setSurroundAudio()
    {
        echo 'ストリーミングプレーヤーのサラウンドをスイッチオン' . PHP_EOL;
    }

    public function setTwoChannelAudio()
    {
        echo 'ストリーミングプレーヤーを２チャンネル設定' . PHP_EOL;
    }

    public function dio()
    {
        echo 'ストリーミングプレーヤーを' . PHP_EOL;
    }

    public function stop()
    {
        echo ('ストリーミングプレーヤーは「' . $this->movie . '」を停止') . PHP_EOL;
    }
}

class Projector
{
    public function on()
    {
        echo 'プロジェクターをスイッチオン' . PHP_EOL;
    }

    public function off()
    {
        echo 'プロジェクターをスイッチオフ' . PHP_EOL;
    }

    public function tvMode()
    {
        echo 'プロジェクターはテレビモードです' . PHP_EOL;
    }

    public function wideScreenMode()
    {
        echo 'プロジェクターはワイドスクリーンモードです' . PHP_EOL;
    }
}

class Screen
{
    public function up()
    {
        echo 'シアターのスクリーンを上げます' . PHP_EOL;
    }

    public function down()
    {
        echo 'シアターのスクリーンを下ろします' . PHP_EOL;
    }
}

class TheaterLights
{
    public function on()
    {
        echo 'シアターの天井照明をスイッチオン' . PHP_EOL;
    }

    public function off()
    {
        echo 'シアターの天井照明をスイッチオフ' . PHP_EOL;
    }

    public function dim(int $number)
    {
        echo ('シアターの天井照明を' . $number . '%まで暗くします') . PHP_EOL;
    }
}

class PopcornPopper
{
    public function on()
    {
        echo 'ポップコーンメーカーのスイッチオン' . PHP_EOL;
    }

    public function off()
    {
        echo 'ポップコーンメーカーのスイッチオフ' . PHP_EOL;
    }

    public function pop()
    {
        echo 'ポップコーンメーカーがポップコーンを作っています' . PHP_EOL;
    }
}

(new HomeTheaterTestDrive())->main();
