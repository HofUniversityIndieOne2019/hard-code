<?php
declare(strict_types=1);
namespace OliverHader\HardCode\Tests\Domain;

use OliverHader\HardCode\Domain\Book;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    /**
     * @test
     */
    public function bookIsCreated(): void
    {
        $subject = new Book();
        self::assertInstanceOf(Book::class, $subject);
    }

    public function bookPropertyIsAssignedDataProvider(): array
    {
        return [
            ['id', rand(1, 1000)],
            ['isbn', uniqid('isbn')],
            ['title', uniqid('title')],
            ['blurb', uniqid('blurb')],
            ['price', rand(1, 1000) / 100],
        ];
    }

    /**
     * @param string $propertyName
     * @param $value
     *
     * @test
     * @dataProvider bookPropertyIsAssignedDataProvider
     */
    public function bookPropertyIsAssigned(string $propertyName, $value)
    {
        $setMethod = 'set' . ucfirst($propertyName);
        $getMethod = 'get' . ucfirst($propertyName);

        $subject = new Book();
        $subject->{$setMethod}($value);
        $result = $subject->{$getMethod}();

        self::assertSame($value, $result);
    }
}