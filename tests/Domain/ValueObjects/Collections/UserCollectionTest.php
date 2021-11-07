<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Collections;

use AMSGuitars\Domain\ValueObjects\Collections\UserCollection;
use AMSGuitars\Domain\ValueObjects\Collections\JsonValueObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Collection\Collection;

class UserCollectionTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $userCollection = new UserCollection();
        self::assertInstanceOf(Collection::class, $userCollection);
        self::assertInstanceOf(JsonValueObject::class, $userCollection);
    }
}