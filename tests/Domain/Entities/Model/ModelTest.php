<?php

declare(strict_types=1);

namespace Tests\Domain\Entities\Model;

use AMSGuitars\Domain\Entities\Entity;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Domain\Models;

class ModelTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $model = (new Models())->aModel();
        self::assertInstanceOf(Entity::class, $model);
    }
}