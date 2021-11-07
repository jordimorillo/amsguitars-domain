<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Identifiers;

use AMSGuitars\Domain\ValueObjects\Identifiers\BrandId;
use AMSGuitars\Domain\ValueObjects\Identifiers\Identifier;
use PHPUnit\Framework\TestCase;

class BrandIdTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $brandId = new BrandId();
        self::assertInstanceOf(Identifier::class, $brandId);
    }
}