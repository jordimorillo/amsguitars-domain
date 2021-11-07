<?php

declare(strict_types=1);

namespace Tests\Infrastructure\ValueObjects\Persistence;

use AMSGuitars\Infrastructure\Exceptions\LimitFormatException;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use PHPUnit\Framework\TestCase;

class LimitTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $limit = new Limit(0, 2);
        self::assertInstanceOf(Limit::class, $limit);
    }

    public function dataProvider(): array
    {
        return [
            [0, 0],
            [-1, 1],
            [0, -1],
        ];
    }

    /** @dataProvider dataProvider() */
    public function testCanThrowExceptionWhenValuesAreNotCorrect(int $offset, int $totalItems): void
    {
        $this->expectException(LimitFormatException::class);
        new Limit($offset, $totalItems);
    }
}