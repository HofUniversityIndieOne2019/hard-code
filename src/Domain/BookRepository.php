<?php
declare(strict_types=1);
namespace OliverHader\HardCode\Domain;

use OliverHader\HardCode\Infrastructure\DataQuery;

class BookRepository
{
    /**
     * @return Book[]
     */
    public function findAll(): array
    {
        $query = $this->createQuery();
        $records = $query->execute();
        return array_map([$this, 'createBook'], $records);
    }

    /**
     * @param string $likeTitle
     * @return Book[]
     */
    public function findByTitle(string $likeTitle): array
    {
        $query = $this->createQuery();
        $query->whereLike('title', $likeTitle);
        $records = $query->execute();
        return array_map([$this, 'createBook'], $records);
    }

    public function findByIdentifier(string $identifier)
    {
        $query = $this->createQuery();
        $query->whereLike('id', '^' . preg_quote($identifier, '#') . '$');
        $record = $query->execute();
        return $this->createBook(array_shift($record));
    }

    protected function createBook(array $record): Book
    {
        $factory = new BookFactory();
        return $factory->fromRecord($record);
    }

    protected function createQuery(): DataQuery
    {
        $query = new DataQuery();
        $query->from('book');
        return $query;
    }
}