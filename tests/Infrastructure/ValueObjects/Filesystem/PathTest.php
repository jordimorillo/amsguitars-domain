<?php

declare(strict_types=1);

namespace Tests\Infrastructure\ValueObjects\Filesystem;

use AMSGuitars\Infrastructure\Exceptions\PathToFileInLinuxInvalidException;
use AMSGuitars\Infrastructure\ValueObjects\Filesystem\Path;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{
    public function validLinuxPaths(): array
    {
        return [
            'A path to a jpg file' => ['/var/www/html/an-image.jpg'],
        ];
    }

    public function invalidLinuxPaths(): array
    {
        return [
            'A path with double slashes' => ['/var//www/html/an-image.jpg'],
            'A path without file' => ['/var/www/html/'],
            'A path without extension' => ['/var/www/html/an-image'],
        ];
    }

    /** @dataProvider validLinuxPaths() */
    public function testCanInstantiate(string $pathToFile): void
    {
        $linuxPathToFile = new Path($pathToFile);
        self::assertInstanceOf(StringValueObject::class, $linuxPathToFile);
    }

    /** @dataProvider invalidLinuxPaths() */
    public function testCanThrowExceptionIfPathIsInvalid(string $invalidPathToFile): void
    {
        $this->expectException(PathToFileInLinuxInvalidException::class);
        new Path($invalidPathToFile);
    }
}