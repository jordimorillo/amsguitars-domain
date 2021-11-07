<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Identifiers;

use AMSGuitars\Domain\ValueObjects\Identifiers\Identifier;
use AMSGuitars\Domain\ValueObjects\Identifiers\InterventionId;
use PHPUnit\Framework\TestCase;

class InterventionIdTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $interventionId = new InterventionId();
        self::assertInstanceOf(Identifier::class, $interventionId);
    }
}