<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Identifiers;

use AMSGuitars\Domain\ValueObjects\Identifiers\Identifier;
use AMSGuitars\Domain\ValueObjects\Identifiers\PersonId;
use PHPUnit\Framework\TestCase;

class PersonIdTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $personId = new PersonId();
        self::assertInstanceOf(Identifier::class, $personId);
    }
}