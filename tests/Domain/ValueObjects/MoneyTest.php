<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\MoneyNotValidException;
use AMSGuitars\Domain\ValueObjects\FloatValueObject;
use AMSGuitars\Domain\ValueObjects\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $money = new Money(123);
        self::assertInstanceOf(FloatValueObject::class, $money);
    }

    public function testCanThrowExceptionWhenMoneyHasNotTwoDecimals(): void
    {
        $this->expectException(MoneyNotValidException::class);
        new Money(123.456);
    }

    public function testCanReturnAMoneyString(): void
    {
        $money = new Money(123.1);
        self::assertEquals('123.10', $money->toString());

        $money = new Money(123);
        self::assertEquals('123.00', $money->tostring());

        $money = new Money(123.45);
        self::assertEquals('123.45', $money->toString());
    }
}