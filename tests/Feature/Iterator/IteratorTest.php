<?php

use Iterator\Aggregate\BooksAggregate;

beforeEach(function () {
    $this->stub = [
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
            'id' => 3,
            'pages' => 237,
            'author_name' => 'Ryu',
        ],
        [
            'id' => 4,
            'pages' => 858,
            'author_name' => 'Touma',
        ],
        [
            'id' => 5,
            'pages' => 200,
            'author_name' => 'Jun',
        ],
    ];
});

it('can be added to an array', function () {
    $aggregate = new BooksAggregate();
    expect([])
        ->toBeArray()
        ->toBe($aggregate->getBookList());

    $aggregate->addBookList($this->stub[0]);
    expect([$this->stub[0]])
        ->toBeArray()
        ->toBe($aggregate->getBookList());

    $aggregate->addBookList($this->stub[1], $this->stub[2], $this->stub[3], $this->stub[4]);
    expect($this->stub)
        ->toBeArray()
        ->toBe($aggregate->getBookList());
});

it('can be iterated', function () {
    $aggregate = new BooksAggregate([$this->stub[0], $this->stub[1]]);
    $iterator = $aggregate->iterator();

    expect($iterator->hasNext())->toBeTrue();
    $except = [
        'books_id' => 1,
        'page_count' => 150,
        'author' => 'Kentaro',
    ];

    expect($except)
        ->toBeArray()
        ->toBe($iterator->next());

    expect($iterator->hasNext())->toBeTrue();
    $except = [
        'books_id' => 2,
        'page_count' => 433,
        'author' => 'Shuichi',
    ];

    expect($except)
        ->toBeArray()
        ->toBe($iterator->next());

    expect($iterator->hasNext())->toBeFalse();
});
