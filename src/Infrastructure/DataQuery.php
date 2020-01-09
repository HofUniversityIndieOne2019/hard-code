<?php
declare(strict_types=1);
namespace OliverHader\HardCode\Infrastructure;

class DataQuery
{
    /**
     * @var string
     */
    private $from = '';

    /**
     * @var array
     */
    private $whereLikes = [];

    public function from(string $from)
    {
        $this->from = $from;
    }

    public function whereLike(string $propertyName, string $propertyValue)
    {
        $this->whereLikes[] = [$propertyName, $propertyValue];
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return array
     */
    public function getWhereLikes(): array
    {
        return $this->whereLikes;
    }

    /**
     * @return array
     * @deprecated Use DataManager::executeQuery directly
     */
    public function execute(): array
    {
        $manager = new DataManager();
        return $manager->executeQuery($this);
    }
}