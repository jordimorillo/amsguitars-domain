<?php

declare(strict_types=1);

namespace Tests\Domain\Entities\Guitar;

use AMSGuitars\Domain\Entities\Entity;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Domain\Guitars;

class GuitarTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $guitar = (new Guitars)->aGuitar();
        self::assertInstanceOf(Entity::class, $guitar);
    }
}