<?php

declare(strict_types=1);

class User implements SplSubject
{
    private SplObjectStorage $observers;

    private $email;

    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }

    public function attach(SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function changeEmail(string $email): void
    {
        $this->email = $email;
        $this->notify();
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}

class UserObserver implements SplObserver
{
    private array $changeUsers = [];

    public function update(SplSubject $subject): void
    {
        $this->changeUsers[] = clone $subject;
    }

    public function getChangeUsers(): array
    {
        return $this->changeUsers;
    }
}

$observer = new UserObserver();
$user = new User();
$user->attach($observer);
$user->changeEmail('test@test.com');
var_dump($observer->getChangeUsers());

// interface SubjectInterface
// {
//     public function addObserver(ObserverInterface $listner);
//     public function removeObserver(ObserverInterface $listner);
//     public function notify();
// }

// interface ObserverInterface
// {
//     public function execute(BulletinBoard $board);
// }

// class BulletinBoard implements SubjectInterface
// {
//     private $name;
//     private $comments = [];
//     private $listners = [];

//     public function __construct($name)
//     {
//         $this->name = $name;
//     }

//     public function comment($message)
//     {
//         echo sprintf("%s : %s", $this->getName(), $message);
//         $this->addComment($message);
//     }

//     public function addComment($message)
//     {
//         $this->comments[] = $message;
//         $this->notify();
//     }

//     public function getComments()
//     {
//         return $this->comments;
//     }

//     public function getName()
//     {
//         return $this->name;
//     }

//     public function addObserver(ObserverInterface $listner)
//     {
//         $this->listners[get_class($listner)] = $listner;
//     }

//     public function removeObserver(ObserverInterface $listner)
//     {
//         unset($this->listners[get_class($listner)]);
//     }

//     public function notify()
//     {
//         foreach ($this->listners as $listner) {
//             $listner->execute($this);
//         }
//     }
// }

// class LoggingListner implements ObserverInterface
// {
//     public function execute(BulletinBoard $board)
//     {
//         print(" Log Writed").PHP_EOL;
//     }
// }

// class MailListner implements ObserverInterface
// {
//     public function execute(BulletinBoard $board)
//     {
//         print(" Mail Sent").PHP_EOL;
//     }
// }

// $user1 = new BulletinBoard('one');
// $user1->addObserver(new LoggingListner);
// $user1->addObserver(new MailListner);

// $user1->comment('hello');
// $user1->comment('night');
