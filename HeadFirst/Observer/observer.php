<?php

declare(strict_types=1);

interface hfSubject
{
    public function registerObserver(hfObserver $observer): void;

    public function removeObserver(hfObserver $observer): void;

    public function notifyObservers();
}

interface hfObserver
{
    public function update();
}

interface DisplayElement
{
    public function display(): void;
}

class WeatherData implements hfSubject
{
    private array $observers;

    private float $temprature;

    private float $humidity;

    private float $pressure;

    public function __construct()
    {
        $this->observers = [];
    }

    public function registerObserver(hfObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function removeObserver(hfObserver $observer): void
    {
        // 未実装
    }

    public function notifyObservers()
    {
        foreach ($this->observers as $obs) {
            $obs->update();
        }
    }

    public function measurementsChanged()
    {
        $this->notifyObservers();
    }

    public function setMeasurements(float $temperature, float $humidity, float $pressure)
    {
        $this->temprature = $temperature;
        $this->humidity = $humidity;
        $this->pressure = $pressure;
        $this->measurementsChanged();
    }

    public function getTemperature()
    {
        return $this->temprature;
    }

    public function getHumidity()
    {
        return $this->humidity;
    }
}
class CurrentConditionsDisplay implements DisplayElement, hfObserver
{
    private float $temperature;

    private float $humidity;

    private WeatherData $weatherData;

    public function __construct(WeatherData $weatherData)
    {
        $this->weatherData = $weatherData;
        $weatherData->registerObserver($this);
    }

    public function update()
    {
        $this->temperature = $this->weatherData->getTemperature();
        $this->humidity = $this->weatherData->getHumidity();
        $this->display();
    }

    public function display(): void
    {
        echo ("現在の気象状況は : 温度->$this->temperature  湿度->$this->humidity") . PHP_EOL;
    }
}

class WeatherStation
{
    public function main()
    {
        $weatherData = new WeatherData();
        $currentDisplay = new CurrentConditionsDisplay($weatherData);

        $weatherData->setMeasurements(80, 65, 30.4);
        $weatherData->setMeasurements(80, 64, 30.4);
        $weatherData->setMeasurements(80, 63, 30.4);

    }
}

$weather = new WeatherStation();
$weather->main();
