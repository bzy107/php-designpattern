<?php

declare(strict_types=1);



interface Subject
{
    public function attach(Observer $observer) : void;
    public function detach(Observer $observer) : void;
    public function notify() : void;
    public function getEvent() : string;
}

interface Observer
{
    public function update(Subject $subject) : void;
    public function getPriority() : int;
}

class Publisher implements Subject
{
    protected array $linkedList = [];
    protected array $observers = [];
    protected string $name;
    protected string $event;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function attach(Observer $observer) : void
    {
        $observerKey = spl_object_hash($observer);
        $this->observers[$observerKey] = $observer;
        $this->linkedList[$observerKey] = $observer->getPriority();

        arsort($this->linkedList);
    }

    public function detach(Observer $observer) : void
    {
        $observerKey = spl_object_hash($observer);
        unset($this->observers[$observerKey]);
        unset($this->linkedList[$observerKey]);
    }

    public function notify() : void
    {
        foreach($this->linkedList as $key => $val) {
            $this->observers[$key]->update($this);
        }
    }

    public function setEvent($event) : void
    {
        $this->event = $event;
        $this->notify();

    }

    public function getEvent() : string
    {
        return $this->event;
    }

    public function getSubscribers()
    {
        return $this->getSubscribers();
    }
}

class Subscriber implements Observer
{
    protected string $name;
    protected int $priority = 0;

    public function __construct(string $name, int $priority = 0)
    {
        $this->name = $name;
        $this->priority = $priority;
    }

    public function update(Subject $subject) : void
    {
        print_r($this->name . ' : ' . $subject->getEvent().PHP_EOL);
    }

    public function getPriority() : int
    {
        return $this->priority;
    }
}


$noty = new Publisher('NotifiationPublisher');

$email = new Subscriber('EmailObserver', 50);
$slack = new Subscriber('SlackObserver', 10);
$dashboard = new Subscriber('DashboardObserver', 30);


$noty->attach($email);
$noty->attach($slack);
$noty->attach($dashboard);




$noty->setEvent('Server XX is going down');


