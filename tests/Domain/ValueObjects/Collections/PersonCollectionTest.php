<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Collections;

use AMSGuitars\Domain\ValueObjects\Collections\JsonValueObject;
use AMSGuitars\Domain\ValueObjects\Collections\PersonCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Collection\Collection;

class PersonCollectionTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $personCollection = new PersonCollection();
        self::assertInstanceOf(Collection::class, $personCollection);
        self::assertInstanceOf(JsonValueObject::class, $personCollection);
    }
}