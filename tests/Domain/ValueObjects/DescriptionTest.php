<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\DescriptionTooLongException;
use AMSGuitars\Domain\ValueObjects\Description;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class DescriptionTest extends TestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    public function testCanInstantiate(): void
    {
        $description = new Description($this->faker->text);
        self::assertInstanceOf(StringValueObject::class, $description);
    }

    public function testWillThrowAnExceptionIfExceedMaxCharacters(): void
    {
        $tooLongText = random_bytes(300);
        $this->expectException(DescriptionTooLongException::class);
        $description = new Description($tooLongText);
    }
}