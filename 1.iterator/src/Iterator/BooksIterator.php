<?php

namespace Iterator\Iterator;

class BooksIterator implements Iterator
{
    public function __construct(
        private array $books,
        private int $index = 0
    ) {
        //
    }

    public function hasNext(): bool
    {
        return isset($this->books[$this->index]);
    }

    public function next(): array
    {
        $book = [];
        $bookData = $this->books[$this->index++];
        $book['books_id'] = $bookData['id'];
        $book['page_count'] = $bookData['pages'];
        $book['author'] = $bookData['author_name'];

        return $book;
    }
}
