<?php

declare(strict_types=1);

define("FILEDIR", dirname(__FILE__));

class Item
{
    public function __construct(
        private int $id, 
        private string $name, 
        private int $price
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }
}

class OrderItem
{
    public function __construct(
        private Item $item,
        private int $amount
    )
    {
        $this->item = $item;
        $this->amount = $amount;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function getAmount()
    {
        return $this->amount;
    }
}

class Order
{
    private $items;
    public function __construct()
    {
        $this->items = [];
    }

    public function addItem(OrderItem $orderItem)
    {
        $this->items[$orderItem->getItem()->getId()] = $orderItem;
    }

    public function getItems()
    {
        return $this->items;
    }
}

class ItemDao
{
    private static $instance;
    private $items;

    public function __construct()
    {
        $fp = fopen(FILEDIR."/item_data.txt", 'r');

        $dummy = fgets($fp, 4096);

        $this->items = [];
        while($buffer = fgets($fp, 4096)) {
            $itemId = trim(substr($buffer, 0, 10));
            $itemName = trim(substr($buffer, 10, 20));
            $itemPrace = trim(substr($buffer, 30));

            $item = new Item((int)$itemId, $itemName, (int)$itemPrace);
            $this->items[$item->getId()] = $item; 
        }

        fclose($fp);
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new ItemDao();
        }
        return self::$instance;
    }

    public function findById($itemId)
    {
        if (array_key_exists($itemId, $this->items)) {
            return $this->items[$itemId];
        } else {
            return null;
        }
    }

    public function setAside(OrderItem $orderItem)
    {
        print($orderItem->getItem()->getName() . " の在庫引当をおこないました").PHP_EOL;
    }

    public final function __clone()
    {
        throw new RuntimeException('CloneIs not allowed against ' . get_class($this));
    }
}


class OrderDao
{
    public static function createOrder(Order $order)
    {
        print('以下の内容で注文データを作成しました').PHP_EOL;
        print("'<table border='1'").PHP_EOL;
        print('<tr>').PHP_EOL;
        print('<th>商品番号</th>').PHP_EOL;
        print('<th>商品名</th>').PHP_EOL;
        print('<th>単価</th>').PHP_EOL;
        print('<th>数量</th>').PHP_EOL;
        print('<th>金額</th>').PHP_EOL;
        print('</tr>').PHP_EOL;

        foreach ($order->getItems() as $orderItem) {
            print("<tr>").PHP_EOL;
            print("<td>" . $orderItem->getItem()->getId() . "</td>").PHP_EOL;
            print("<td>" . $orderItem->getItem()->getName() . "</td>").PHP_EOL;
            print("<td>" . $orderItem->getItem()->getPrice() . "</td>").PHP_EOL;
            print("<td>" . $orderItem->getAmount() . "</td>").PHP_EOL;
            print("<td>" . $orderItem->getItem()->getPrice() * $orderItem->getAmount() . "</td>").PHP_EOL;
            print("</table>").PHP_EOL;
        }
    }
}

class OrderManager
{
    public static function order(Order $order)
    {
        $itemDao = ItemDao::getInstance();
        foreach ($order->getItems() as $orderItem) {
            $itemDao->setAside($orderItem);
        }

        OrderDao::createOrder($order);
    }
}


$order = new Order();
$itemOrder = ItemDao::getInstance();

$order->addItem(new OrderItem($itemOrder->findById(1), 2));
$order->addItem(new OrderItem($itemOrder->findById(2), 1));
$order->addItem(new OrderItem($itemOrder->findById(3), 3));

OrderManager::order($order);


// https://shimooka.hateblo.jp/entry/20141215/1418620292