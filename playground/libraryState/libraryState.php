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
            static::$instance = new self();
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
            static::$instance = new self();
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
            static::$instance = new self();
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
            static::$instance = new self();
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

    public function setDocumentId(int $documentId) : self
    {
        return new self(new ReserveStatus(), $documentId);
    }

    public function update()
    {
        $this->currentStatus->updateState($this);
    }
}


print "実行開始[メモリ使用量]：". memory_get_usage() / (1024 * 1024) ."MB\n";
print "実行開始[メモリ最大使用量]：". memory_get_peak_usage() / (1024 * 1024) ."MB\n";
print "-----------------------------------------------\n";

$books = new StatusContext(new ReserveStatus(), 123);
$books->update();
$books->update();
$books->update();
$books2 = $books->setDocumentId(456);
print "処理1実行後[メモリ使用量]：". memory_get_usage() / (1024 * 1024) ."MB\n";
print "処理1実行後[メモリ最大使用量]：". memory_get_peak_usage() / (1024 * 1024) ."MB\n";
print "-----------------------------------------------\n";

$books->update();
$books->update();
$books->update();

$books2->update();
$books2->update();
$books2->update();
$books2->update();

print "処理2実行後[メモリ使用量]：". memory_get_usage() / (1024 * 1024) ."MB\n";
print "処理2実行後[メモリ最大使用量]：". memory_get_peak_usage() / (1024 * 1024) ."MB\n";
print "-----------------------------------------------\n";

