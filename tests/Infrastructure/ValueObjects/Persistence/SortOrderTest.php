<?php

declare(strict_types=1);

namespace Tests\Infrastructure\ValueObjects\Persistence;

use AMSGuitars\Infrastructure\ValueObjects\Persistence\Column;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortDirection;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;
use PHPUnit\Framework\TestCase;

class SortOrderTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $sortOrder = new SortOrder(new Column('aColumn'), SortDirection::ASC());
        self::assertInstanceOf(SortOrder::class, $sortOrder);
    }
}