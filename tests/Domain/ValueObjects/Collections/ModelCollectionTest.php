<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Collections;

use AMSGuitars\Domain\ValueObjects\Collections\JsonValueObject;
use AMSGuitars\Domain\ValueObjects\Collections\ModelCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Collection\Collection;

class ModelCollectionTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $modelCollection = new ModelCollection();
        self::assertInstanceOf(Collection::class, $modelCollection);
        self::assertInstanceOf(JsonValueObject::class, $modelCollection);
    }
}