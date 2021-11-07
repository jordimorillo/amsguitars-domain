<?php

declare(strict_types=1);

namespace Tests\Domain\Entities\Brand;

use AMSGuitars\Domain\Entities\Entity;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Domain\Brands;

class BrandTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $brand = (new Brands())->aBrand();
        self::assertInstanceOf(Entity::class, $brand);
    }
}