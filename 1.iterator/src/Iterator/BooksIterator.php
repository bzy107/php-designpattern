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
        $bookData = $this->books[$this->index++];

        return $this->getFormattedData($bookData);
    }

    public function getFormattedData(array $data): array
    {
        $book = [];

        $book['books_id'] = $data['id'];
        $book['page_count'] = $data['pages'];
        $book['author'] = $data['author_name'];

        return $book;
    }
}
