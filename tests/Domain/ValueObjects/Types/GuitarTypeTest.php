<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Types;

use AMSGuitars\Domain\ValueObjects\Types\GuitarType;
use PHPUnit\Framework\TestCase;

class GuitarTypeTest extends TestCase
{
    public function testHasTypeClassic(): void
    {
        self::assertEquals('Classic', GuitarType::CLASSIC());
    }

    public function testHasTypeModern(): void
    {
        self::assertEquals('Modern', GuitarType::MODERN());
    }
}