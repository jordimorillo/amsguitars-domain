<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Identifiers;

use AMSGuitars\Domain\ValueObjects\Identifiers\Identifier;
use AMSGuitars\Domain\ValueObjects\Identifiers\PhotoId;
use PHPUnit\Framework\TestCase;

class PhotoIdTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $photoId = new PhotoId();
        self::assertInstanceOf(Identifier::class, $photoId);
    }
}