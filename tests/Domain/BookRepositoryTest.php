<?php
declare(strict_types=1);
namespace OliverHader\HardCode\Tests\Domain;

use OliverHader\HardCode\Domain\Book;
use OliverHader\HardCode\Domain\BookFactory;
use OliverHader\HardCode\Domain\BookRepository;
use OliverHader\HardCode\Infrastructure\DataManager;
use OliverHader\HardCode\Infrastructure\DataQuery;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BookRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function findAllIsExecuted()
    {
        $expectedBook1 = new Book();
        $expectedBook2 = new Book();

        $dataQuery = $this->getMockBuilder(DataQuery::class)
            ->onlyMethods(['execute'])
            ->getMock();
        $dataQuery->expects(self::never())
            ->method('execute');

        $dataManager = $this->getMockBuilder(DataManager::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['executeQuery'])
            ->getMock();
        $dataManager->expects(self::once())
            ->method('executeQuery')
            ->with($dataQuery)
            ->willReturn([
                ['isbn' => 'test1'],
                ['isbn' => 'test2'],
            ]);

        $bookFactory = $this->getMockBuilder(BookFactory::class)
            ->onlyMethods(['fromRecord'])
            ->getMock();
        $bookFactory->expects(self::at(0))
            ->method('fromRecord')
            ->with(['isbn' => 'test1'])
            ->willReturn($expectedBook1);
        $bookFactory->expects(self::at(1))
            ->method('fromRecord')
            ->with(['isbn' => 'test2'])
            ->willReturn($expectedBook2);

        /** @var MockObject|BookRepository $subject */
        $subject = $this->getMockBuilder(BookRepository::class)
            ->setConstructorArgs([$bookFactory, $dataManager])
            ->onlyMethods(['createQuery'])
            ->getMock();
        $subject->expects(self::once())
            ->method('createQuery')
            ->willReturn($dataQuery);

        $result = $subject->findAll();
        self::assertSame([$expectedBook1, $expectedBook2], $result);
    }
}