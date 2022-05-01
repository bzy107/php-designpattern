<?php
declare(strict_types=1);


abstract class Entry
{
    private $code;
    private $name;

    public function __construct($code, $name)
    {
        $this->code = $code;
        $this->name = $name;
    }
    public abstract function add(Entry $entry);

    public function dump()
    {
        echo $this->code . ' : ' . $this->name . PHP_EOL;
    }
}

class Component extends Entry
{
    private $entries;

    public function __construct($code, $name)
    {
        parent::__construct($code, $name);
        $this->entries = [];
    }

    public function add(Entry $entry)
    {
        array_push($this->entries, $entry);
    }

    public function dump()
    {
        parent::dump();
        foreach ($this->entries as $entry) {
            $entry->dump();
        }
    }
}


class Leaf extends Entry
{
    public function __construct($code, $name)
    {
        parent::__construct($code, $name);
    }

    public function add(Entry $entry)
    {
        throw new Exception('add not allowed');
    }
}


$root = new Component('001', 'root1');
$group1_1 = new Component('001/001', 'group1/001');
$group1_1->add(new Leaf('001/001/001', 'leaf1/001'));
$group1_1->add(new Leaf('001/001/002', 'leaf1/002'));

$root->add($group1_1);
$group1_2 = new Component('001/002', 'group1/002');
$root->add($group1_2);
$root->dump();
