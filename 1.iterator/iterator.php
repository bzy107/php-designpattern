<?php
declare(strict_types=1);



// 著者一覧のデータ[詳細]
$book_list = [
	[
		'family-name' => 'Matumoto',
		'given-name'  => 'Jun',
		'id'          => 5
	],
	[
		'family-name' => 'Kobayashi',
		'given-name'  => 'Kentaro',
		'id'          => 1,
	],
	[
		'family-name' => 'Mudata',
		'given-name'  => 'Shuichi',
		'id'          => 2
	],
	[
		'family-name' => 'Kamijou',
		'given-name'  => 'Touma',
		'id'          => 4
	],
	[
		'family-name' => 'Murakami',
		'given-name'  => 'Ryu',
		'id'          => 3
	],
];


interface Aggregate 
{
    public function createiterator();
}

interface BookIterator 
{
    public function hasNext();
    public function next();
}

/**
 * 本の集約オブジェクト
 */
class BooksAggregate implements Aggregate
{
    private array $bookList;

    public function __construct(array $books)
    {
        $this->bookList = $books;
    }

    public function addBookList($book)
    {
        $this->bookList[] = $book;
    }

    public function getBookList()
    {
        return $this->bookList;
    }

    public function createiterator()
    {
        return new BookListIterator($this->bookList);
        // return new BookListIterator2($this->bookList); // ここで具象クラスを切り替えできる
    }

}

/**
 * 本のイテレータ
 */
class BookListIterator implements BookIterator
{
    private array $books;
    private int $index = 0;

    public function __construct(array $books)
    {
        $this->books = $books;
    }

    public function hasNext() : bool
    {
        return isset($this->books[$this->index]);
    }

    public function next() : array
    {
        $book = [];
        $bk = $this->books[$this->index++];
        $book['books'] = $bk['id'];
        $book['last'] = $bk['family-name'];
        $book['first'] = $bk['given-name'];
        return $book;
    }
}


/**
 * 本のイテレータ2
 */
class BookListIterator2 implements BookIterator
{
    private array $books;
    private int $index = 0;

    public function __construct(array $books)
    {
        $this->books = $books;
    }

    public function hasNext() : bool
    {
        return isset($this->books[$this->index]);
    }

    public function next() : array
    {
        $book = [];
        $bk = $this->books[$this->index++];
        $book['books'] = $bk['family-name'];
        $book['last'] = $bk['id'];
        $book['first'] = $bk['given-name'];
        return $book;
    }
}

/**
 * 表示を担当
 */
class DisplayClient
{
    private $bookIterator;

    public function __construct(BooksAggregate $bookList)
    {
        $this->bookIterator = $bookList->createIterator();
    }

    public function getBooks()
    {
        while($this->bookIterator->hasNext()) 
        {
            $book = $this->bookIterator->next();
            // echo $book;
            echo sprintf("%s %s %s", $book['books'], $book['last'], $book['first']);
            echo PHP_EOL;
        }
    }
}

$book = new DisplayClient(new BooksAggregate($book_list));
echo $book->getBooks();