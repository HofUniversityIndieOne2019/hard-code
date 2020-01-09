<?php
declare(strict_types=1);
namespace OliverHader\HardCode\Tests\Domain;

use OliverHader\HardCode\Infrastructure\DataManager;
use OliverHader\HardCode\Infrastructure\DataQuery;
use OliverHader\HardCode\Infrastructure\FileReader;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DataManagerTest extends TestCase
{
    public function executeQueryReturnsRecordsDataProvider(): array
    {
        $allBooksQuery = new DataQuery();
        $allBooksQuery->from('book');

        $secondBookQuery = new DataQuery();
        $secondBookQuery->from('book');
        $secondBookQuery->whereLike('isbn', 'isbn2');

        return [
            'all books' => [
                $allBooksQuery,
                [
                    [
                        'isbn' => 'isbn1',
                        'title' => 'title1',
                    ],
                    [
                        'isbn' => 'isbn2',
                        'title' => 'title2',
                    ],
                ]
            ],
            'second book only' => [
                $secondBookQuery,
                [
                    [
                        'isbn' => 'isbn2',
                        'title' => 'title2',
                    ],
                ]
            ]
        ];
    }

    /**
     * @param DataQuery $query
     * @param array $expectation
     *
     * @test
     * @dataProvider executeQueryReturnsRecordsDataProvider
     */
    public function executeQueryReturnsRecords(DataQuery $query, array $expectation)
    {
        /** @var MockObject|FileReader $fileReader */
        $fileReader = $this->getMockBuilder(FileReader::class)
            ->setConstructorArgs([uniqid('data')])
            ->onlyMethods(['readJson'])
            ->getMock();
        $fileReader->expects(self::once())
            ->method('readJson')
            ->willReturn([
                'book' => [
                    [
                        'isbn' => 'isbn1',
                        'title' => 'title1',
                    ],
                    [
                        'isbn' => 'isbn2',
                        'title' => 'title2',
                    ],
                ],
            ]);

        $subject = new DataManager($fileReader);

        $result = $subject->executeQuery($query);
        self::assertSame($expectation, $result);
    }
}