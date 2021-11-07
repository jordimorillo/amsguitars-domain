<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\RegionTooLongException;
use AMSGuitars\Domain\ValueObjects\Region;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class RegionTest extends TestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create('es_ES');
    }
    
    public function tesCanInstantiate(): void
    {
        $region = new Region($this->faker->state);
        self::assertInstanceOf(StringValueObject::class, $region);
    }

    public function testExceptionShouldBeThrownWhenExceedingMaxChars(): void {

        $tooLongRegion = random_bytes(200);
        $this->expectException(RegionTooLongException::class);
        $region = new Region($tooLongRegion);
    }
}