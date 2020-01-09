<?php
declare(strict_types=1);
namespace OliverHader\HardCode\Tests\Domain;

use OliverHader\HardCode\Infrastructure\FileReader;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class FileReaderTest extends TestCase
{
    /**
     * vfs://root
     *
     * @var vfsStream
     */
    private $fileSystem;

    /**
     * @var string
     */
    private $rawJson;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rawJson = file_get_contents(__DIR__ . '/Fixtures/information.json');
        $this->fileSystem = vfsStream::setup('root', null, [
            'directory' => [
                'information.json' => $this->rawJson,
                'data.json' => $this->rawJson,
            ],
        ]);
    }

    protected function tearDown(): void
    {
        unset($this->rawJson, $this->fileSystem);
        parent::tearDown();
    }

    public function readJsonReturnsDataDataProvider(): array
    {
        return [
            ['directory/information.json'],
            ['directory/data.json'],
        ];
    }

    /**
     * @param string $filePath
     *
     * @test
     * @dataProvider readJsonReturnsDataDataProvider
     */
    public function readJsonReturnsData(string $filePath)
    {
        $expectation = json_decode($this->rawJson, true);
        $subject = new FileReader($this->fileSystem->url());
        $result = $subject->readJson($filePath);
        self::assertSame($expectation, $result);
    }
}