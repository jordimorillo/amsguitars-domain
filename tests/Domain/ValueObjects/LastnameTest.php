<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\LastnameTooLongException;
use AMSGuitars\Domain\ValueObjects\Lastname;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class LastnameTest extends TestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    public function testCanInstantiate(): void
    {
        $lastname = new Lastname($this->faker->lastName);
        self::assertInstanceOf(StringValueObject::class, $lastname);
    }

    public function testCanThrowMaxCharsExceededException(): void
    {
        $lastnameValue = random_bytes(200);
        $this->expectException(LastnameTooLongException::class);
        $lastname = new Lastname($lastnameValue);
    }
}