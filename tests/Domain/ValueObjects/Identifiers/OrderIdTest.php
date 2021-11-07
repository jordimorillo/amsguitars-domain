<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Identifiers;

use AMSGuitars\Domain\ValueObjects\Identifiers\Identifier;
use AMSGuitars\Domain\ValueObjects\Identifiers\OrderId;
use PHPUnit\Framework\TestCase;

class OrderIdTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $orderId = new OrderId();
        self::assertInstanceOf(Identifier::class, $orderId);
    }
}