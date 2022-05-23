<?php

declare(strict_types=1);


interface Status
{
    public function updateState(StatusContext $statusContext);
}

class ReserveStatus implements Status
{
    private static ?ReserveStatus $instance = null;

    public static function getInstance() : Status
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function updateState(StatusContext $statusContext)
    {
        echo 'ReserveStatus : documentId-> ' . $statusContext->getDocumentId().PHP_EOL;
        $statusContext->setcurrentStatus(LendingState::getInstance());
    }
}

class LendingState implements Status
{
    private static ?LendingState $instance = null;

    public static function getInstance() : Status
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function updateState(StatusContext $statusContext)
    {
        echo 'LendingState : documentId-> ' . $statusContext->getDocumentId().PHP_EOL;
        $statusContext->setcurrentStatus(TakeBackState::getInstance());
    }

}

class TakeBackState implements Status
{
    private static ?TakeBackState $instance = null;


    public static function getInstance() : Status
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function updateState(StatusContext $statusContext)
    {
        echo 'TakeBackState : documentId-> ' . $statusContext->getDocumentId().PHP_EOL;
        $statusContext->setcurrentStatus(DoneState::getInstance());
    }
}

class DoneState implements Status
{
    private static ?DoneState $instance = null;

    public static function getInstance() : Status
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function updateState(StatusContext $statusContext)
    {
        echo 'DoneState : documentId-> ' . $statusContext->getDocumentId().PHP_EOL;
    }
}



class StatusContext
{
    public function __construct(
        private Status $currentStatus,
        private int $documentId
    ) {
        $this->documentId = $documentId;
        $this->currentStatus = $currentStatus;
        if (is_null($this->currentStatus)) {
            $this->currentStatus = ReserveStatus::getInstance();
        }
    }

    public function setcurrentStatus(Status $currentStatus)
    {
        $this->currentStatus = $currentStatus;
    }

    public function getDocumentId() : int
    {
        return $this->documentId;
    }

    public function update()
    {
        $this->currentStatus->updateState($this);
    }
}


$books = new StatusContext(new ReserveStatus(), 123);
$books->update();
$books->update();
$books->update();
$books->update();
$books->update();
$books->update();