<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects;

use AMSGuitars\Domain\Exceptions\FirstnameTooLongException;
use AMSGuitars\Domain\ValueObjects\Firstname;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use PHPUnit\Framework\TestCase;

class FirstnameTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $firstname = new Firstname(random_bytes(80));
        self::assertInstanceOf(StringValueObject::class, $firstname);
    }

    public function testCanThrowExceptionOnMaxCharsExceed(): void
    {
        $tooLongText = random_bytes(100);
        $this->expectException(FirstnameTooLongException::class);
        $firstname = new Firstname($tooLongText);
    }
}