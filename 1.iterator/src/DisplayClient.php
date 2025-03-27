<?php

require './vendor/autoload.php';

use Iterator\Aggregate\BooksAggregate;
use Iterator\Iterator\Iterator;

class DisplayClient
{
    private Iterator $bookIterator;

    public function __construct(
        BooksAggregate $books
    ) {
        $this->bookIterator = $books->iterator();
    }

    public function getBooks(): void
    {
        while($this->bookIterator->hasNext()) {
            $book = $this->bookIterator->next();

            echo sprintf("%s %s %s", $book['books_id'], $book['page_count'], $book['author']);
            echo PHP_EOL;
        }
    }

    public static function getStubBook(): array
    {
        return [
            [
                'id' => 5,
                'pages' => 200,
                'author_name' => 'Jun',
            ],
            [
                'id' => 1,
                'pages' => 150,
                'author_name' => 'Kentaro',
            ],
            [
                'id' => 2,
                'pages' => 433,
                'author_name' => 'Shuichi',
            ],
            [
                'id' => 4,
                'pages' => 858,
                'author_name' => 'Touma',
            ],
            [
                'id' => 3,
                'pages' => 237,
                'author_name' => 'Ryu',
            ],
        ];
    }
}

$books = new DisplayClient(new BooksAggregate(DisplayClient::getStubBook()));
echo $books->getBooks();
