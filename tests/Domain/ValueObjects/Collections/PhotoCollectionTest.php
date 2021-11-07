<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Collections;

use AMSGuitars\Domain\ValueObjects\Collections\JsonValueObject;
use AMSGuitars\Domain\ValueObjects\Collections\PhotoCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Collection\Collection;

class PhotoCollectionTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $photoCollection = new PhotoCollection();
        self::assertInstanceOf(Collection::class, $photoCollection);
        self::assertInstanceOf(JsonValueObject::class, $photoCollection);
    }
}