<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\InvalidZipcodeException;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use AMSGuitars\Domain\ValueObjects\Zipcode;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class ZipcodeTest extends TestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create('es_ES');
    }

    public function testCanInstantiate(): void
    {
        $zipcode = new Zipcode($this->faker->postcode);
        self::assertInstanceOf(StringValueObject::class, $zipcode);
    }

    /** @dataProvider invalidZipcodes() */
    public function testCanThrowExceptionWhenPassedStringIsNotAValidZipcode(string $invalidZipcode): void
    {
        $this->expectException(InvalidZipcodeException::class);
        $zipcode = new Zipcode($invalidZipcode);
    }

    public function invalidZipcodes(): array
    {
        return [
            'Are string' => ['abcde'],
            'Count less than 5 chars' => [(string)random_int(1000, 9999)],
            'Count more than 5 chars' => [(string)random_int(100000, 999999)],
        ];
    }
}