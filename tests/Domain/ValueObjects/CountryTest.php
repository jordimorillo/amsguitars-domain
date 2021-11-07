<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\CountryTooLongException;
use AMSGuitars\Domain\ValueObjects\Country;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create('es_ES');
    }

    public function testCanInstantiate(): void
    {
        $country = new Country($this->faker->country);
        self::assertInstanceOf(StringValueObject::class, $country);
    }

    public function testCanThrowExceptionWhenExceedMaxChars(): void
    {
        $tooLongCountry = random_bytes(200);
        $this->expectException(CountryTooLongException::class);
        $country = new Country($tooLongCountry);
    }
}