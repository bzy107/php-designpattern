<?php

namespace Iterator\Aggregate;

use Iterator\Iterator\BooksIterator;

class BooksAggregate implements Aggregate
{
    public function __construct(private array $books)
    {
        //
    }

    public function addBookList(array $book): void
    {
        $this->books[] = $book;
    }

    public function getBookList(): array
    {
        return $this->books;
    }

    public function iterator(): BooksIterator
    {
        return new BooksIterator($this->books);
    }
}
