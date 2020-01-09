<?php
declare(strict_types=1);
namespace OliverHader\HardCode\Infrastructure;

class DataManager
{
    public function executeQuery(DataQuery $dataQuery): array
    {
        return $this->execute($dataQuery->getFrom(), $dataQuery->getWhereLikes());
    }

    /**
     * @param string $from
     * @param array $whereLikes
     * @return array
     * @deprecated Use executeQuery instead
     */
    public function query(string $from, array $whereLikes = []): array
    {
        return $this->execute($from, $whereLikes);
    }

    protected function execute(string $from, array $whereLikes = []): array
    {
        $allData = $this->readData();

        $data = $allData[$from] ?? [];
        $data = array_filter(
            $data,
            function ($record) use ($whereLikes) {
                foreach ($whereLikes as $propertyName => $propertyValue) {
                    if (!isset($record[$propertyName])) {
                        return false;
                    }
                    if (!preg_match('#' . $propertyValue . '#', $record[$propertyName])) {
                        return false;
                    }
                }
                return true;
            }
        );
        return $data;
    }

    protected function readData(): array
    {
        $dataFile = $GLOBALS['ROOT_DIRECTORY'] . '/data/data.json';
        $rawData = file_get_contents($dataFile);
        return json_decode($rawData, true) ?? [];
    }
}