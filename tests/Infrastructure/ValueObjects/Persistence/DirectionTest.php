<?php

declare(strict_types=1);

namespace Tests\Infrastructure\ValueObjects\Persistence;

use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortDirection;
use PHPUnit\Framework\TestCase;

class DirectionTest extends TestCase
{
    public function testCanHaveAscDirection(): void
    {
        self::assertEquals('asc', SortDirection::ASC());
    }

    public function testCanHaveDescDirection(): void
    {
        self::assertEquals('desc', SortDirection::DESC());
    }
}