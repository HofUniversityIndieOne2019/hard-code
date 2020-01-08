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
}