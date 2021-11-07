<?php

declare(strict_types=1);

namespace Tests\Infrastructure\ValueObjects\Persistence;

use AMSGuitars\Domain\ValueObjects\StringValueObject;
use AMSGuitars\Infrastructure\Exceptions\ColumnFormatException;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Column;
use PHPUnit\Framework\TestCase;

class ColumnTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $column = new Column('aColumn');
        self::assertInstanceOf(StringValueObject::class, $column);
    }

    public function dataProvider(): array
    {
        return [
            ['a-Column'],
            ['a Column'],
            ['a123Column'],
            ['a%Column']
        ];
    }

    /** @dataProvider dataProvider() */
    public function testCanThrowExceptionWhenFormatIsNotCorrect(string $incorrectColumnValue): void
    {
        $this->expectException(ColumnFormatException::class);
        $column = new Column($incorrectColumnValue);
    }
}