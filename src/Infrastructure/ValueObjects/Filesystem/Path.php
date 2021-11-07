<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\ValueObjects\Filesystem;

use AMSGuitars\Domain\ValueObjects\StringValueObject;
use AMSGuitars\Infrastructure\Exceptions\PathToFileInLinuxInvalidException;

class Path implements StringValueObject
{
    private string $pathToFile;

    public function __construct(string $pathToFile)
    {
        $this->validate($pathToFile);
        $this->pathToFile = $pathToFile;
    }

    public function toString(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->pathToFile;
    }

    private function validate(string $pathToFile): void
    {
        if(strpos($pathToFile, '//') > 0) {
            throw new PathToFileInLinuxInvalidException('Path is not a valid file path: '.$pathToFile);
        }
        if(preg_match('/^(\/[^\/ ]*)+\/?[.][a-z]{3}$/', $pathToFile) === 0) {
            throw new PathToFileInLinuxInvalidException('Path is not a valid file path: '.$pathToFile);
        }
    }
}