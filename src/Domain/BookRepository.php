<?php
declare(strict_types=1);
namespace OliverHader\HardCode\Domain;

use OliverHader\HardCode\Infrastructure\DataManager;
use OliverHader\HardCode\Infrastructure\DataQuery;

class BookRepository
{
    /**
     * @var BookFactory
     */
    private $bookFactory;

    /**
     * @var DataManager
     */
    private $dataManager;

    public function __construct(BookFactory $bookFactory = null, DataManager $dataManager = null)
    {
        $this->bookFactory = $bookFactory ?? new BookFactory();
        $this->dataManager = $dataManager ?? new DataManager();
    }

    /**
     * @return Book[]
     */
    public function findAll(): array
    {
        $query = $this->createQuery();
        $records = $this->dataManager->executeQuery($query);
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
        $records = $this->dataManager->executeQuery($query);
        return array_map([$this, 'createBook'], $records);
    }

    public function findByIdentifier(string $identifier)
    {
        $query = $this->createQuery();
        $query->whereLike('id', '^' . preg_quote($identifier, '#') . '$');
        $record = $query->execute();
        return $this->createBook(array_shift($record));
    }

    private function createBook(array $record): Book
    {
        return $this->bookFactory->fromRecord($record);
    }

    protected function createQuery(): DataQuery
    {
        $query = new DataQuery();
        $query->from('book');
        return $query;
    }
}