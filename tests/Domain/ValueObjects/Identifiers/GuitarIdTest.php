<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Identifiers;

use AMSGuitars\Domain\ValueObjects\Identifiers\GuitarId;
use AMSGuitars\Domain\ValueObjects\Identifiers\Identifier;
use PHPUnit\Framework\TestCase;

class GuitarIdTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $guitarId = new GuitarId();
        self::assertInstanceOf(Identifier::class, $guitarId);
    }
}