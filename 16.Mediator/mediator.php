<?php

declare(strict_types=1);

interface Mediator
{
    public function getUser(string $username) : string;
}

abstract class Colleague
{
    protected Mediator $mediator;

    public function setMediator(Mediator $mediator)
    {
        $this->mediator = $mediator;
    }
}

class Ui extends Colleague
{
    public function outputUserInfo(string $username)
    {
        print($this->mediator->getUser($username)).PHP_EOL;
    }
}

class UserRepository extends Colleague
{
    public function getUserName(string $user) : string
    {
        return "User: $user";
    }
}

class UserRepositoryUiMediator implements Mediator
{
    public function __construct(private UserRepository $userRepository,  private Ui $ui)
    {
        $this->userRepository->setMediator($this);
        $this->ui->setMediator($this);
    }

    public function printInfoAbout(string $user)
    {
        $this->ui->outputUserInfo($user);
    }

    public function getUser(string $username) : string
    {
        return $this->userRepository->getUserName($username);
    }
}



$mediator = new UserRepositoryUiMediator(new UserRepository(), new Ui());
$mediator->printInfoAbout("Dominik");

