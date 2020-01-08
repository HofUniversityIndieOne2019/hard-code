<?php
declare(strict_types=1);
namespace OliverHader\HardCode\Domain;

class BookFactory
{
    public function fromRecord(array $record): Book
    {
        $book = new Book();
        $book->setId($record['id']);
        $book->setIsbn($record['isbn']);
        $book->setTitle($record['title']);
        $book->setBlurb($record['blurb']);
        $book->setPrice($record['price']);
        return $book;
    }
}