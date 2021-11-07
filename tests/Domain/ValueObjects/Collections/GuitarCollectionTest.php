<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Collections;

use AMSGuitars\Domain\ValueObjects\Collections\GuitarCollection;
use AMSGuitars\Domain\ValueObjects\Collections\JsonValueObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Collection\Collection;

class GuitarCollectionTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $guitarCollection = new GuitarCollection();
        self::assertInstanceOf(Collection::class, $guitarCollection);
        self::assertInstanceOf(JsonValueObject::class, $guitarCollection);
    }
}