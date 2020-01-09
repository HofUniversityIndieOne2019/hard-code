<?php
declare(strict_types=1);
namespace OliverHader\HardCode\Infrastructure;

class FileReader
{
    /**
     * @var string
     */
    private $rootDirectory;

    public function __construct(string $rootDirectory = null)
    {
        $this->rootDirectory = rtrim($rootDirectory ?? $GLOBALS['ROOT_DIRECTORY'], '/');
    }

    public function readJson(string $filePath): array
    {
        $dataFile = $this->rootDirectory . '/' . ltrim($filePath, '/');
        $rawData = file_get_contents($dataFile);
        return json_decode($rawData, true) ?? [];
    }
}