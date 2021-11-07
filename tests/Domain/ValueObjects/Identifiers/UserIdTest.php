<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Identifiers;

use AMSGuitars\Domain\ValueObjects\Identifiers\Identifier;
use AMSGuitars\Domain\ValueObjects\Identifiers\UserId;
use PHPUnit\Framework\TestCase;

class UserIdTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $userId = new UserId();
        self::assertInstanceOf(Identifier::class, $userId);
    }
}