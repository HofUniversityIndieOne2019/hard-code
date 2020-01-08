<?php
declare(strict_types=1);
namespace OliverHader\HardCode\Infrastructure;

class DataQuery
{
    private $from;
    private $whereLikes = [];

    public function from(string $from)
    {
        $this->from = $from;
    }

    public function whereLike(string $propertyName, string $propertyValue)
    {
        $this->whereLikes[] = [$propertyName, $propertyValue];
    }

    public function execute(): array
    {
        $manager = new DataManager();
        return $manager->query($this->from, $this->whereLikes);
    }
}