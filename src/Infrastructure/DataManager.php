<?php
declare(strict_types=1);
namespace OliverHader\HardCode\Infrastructure;

class DataManager
{
    /**
     * @var FileReader
     */
    private $fileReader;

    public function __construct(FileReader $fileReader = null)
    {
        $this->fileReader = $fileReader ?? new FileReader($GLOBALS['ROOT_DIRECTORY']);
    }

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

    private function execute(string $from, array $whereLikes = []): array
    {
        $allData = $this->fileReader->readJson('data/data.json');

        $data = $allData[$from] ?? [];
        $data = array_filter(
            $data,
            function ($record) use ($whereLikes) {
                foreach ($whereLikes as $whereLike) {
                    [$propertyName, $propertyValue] = $whereLike;
                    if (!isset($record[$propertyName])) {
                        var_dump($record, $propertyName);
                        return false;
                    }
                    if (!preg_match('#' . $propertyValue . '#', $record[$propertyName])) {
                        return false;
                    }
                }
                return true;
            }
        );
        return array_values($data);
    }
}