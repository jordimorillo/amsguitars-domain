<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use AMSGuitars\Domain\ValueObjects\Features;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class FeaturesTest extends TestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create('es_ES');
    }

    public function testCanInstantiate(): void
    {
        $features = new Features($this->faker->text);
        self::assertInstanceOf(StringValueObject::class, $features);
    }
}