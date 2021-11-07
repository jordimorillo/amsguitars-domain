<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use AMSGuitars\Domain\ValueObjects\Identifiers\Identifier;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use PHPUnit\Framework\TestCase;

class IdentifierTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $identifier = new Identifier();
        self::assertInstanceOf(StringValueObject::class, $identifier);
    }

    public function testCanObtainAUniqueIdentifier(): void
    {
        $identifier1 = new Identifier();
        $identifier2 = new Identifier();
        self::assertNotEquals($identifier1->toString(), $identifier2->toString());
    }
}