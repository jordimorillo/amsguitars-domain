<?php

declare(strict_types=1);

namespace Tests\Domain\Entities\Photo;

use AMSGuitars\Domain\Entities\Entity;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Domain\Photos;

class PhotoTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $photo = (new Photos)->aPhoto();
        self::assertInstanceOf(Entity::class, $photo);
    }
}