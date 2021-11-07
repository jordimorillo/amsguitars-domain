<?php

namespace Tests\Domain\ValueObjects\Collections;

use AMSGuitars\Domain\ValueObjects\Collections\BrandCollection;
use AMSGuitars\Domain\ValueObjects\Collections\JsonValueObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Collection\Collection;

class BrandCollectionTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $brandCollection = new BrandCollection();
        self::assertInstanceOf(Collection::class, $brandCollection);
        self::assertInstanceOf(JsonValueObject::class, $brandCollection);
    }
}