<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Collections;

use AMSGuitars\Domain\ValueObjects\Collections\InterventionCollection;
use AMSGuitars\Domain\ValueObjects\Collections\JsonValueObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Collection\Collection;

class InterventionCollectionTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $interventionCollection = new InterventionCollection();
        self::assertInstanceOf(Collection::class, $interventionCollection);
        self::assertInstanceOf(JsonValueObject::class, $interventionCollection);
    }
}