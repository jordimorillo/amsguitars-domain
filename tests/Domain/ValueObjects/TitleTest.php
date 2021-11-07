<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\TitleTooLongException;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use AMSGuitars\Domain\ValueObjects\Title;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class TitleTest extends TestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    public function testCanInstantiate(): void
    {
        $title = new Title($this->faker->title);
        self::assertInstanceOf(StringValueObject::class, $title);
    }

    public function testWillThrowExceptionWhenExceedsMaxCharacters(): void
    {
        $tooLongText = random_bytes(151);
        $this->expectException(TitleTooLongException::class);
        $title = new Title($tooLongText);
    }
}