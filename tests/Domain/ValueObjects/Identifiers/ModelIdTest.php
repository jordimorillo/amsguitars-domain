<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObjects\Identifiers;

use AMSGuitars\Domain\ValueObjects\Identifiers\Identifier;
use AMSGuitars\Domain\ValueObjects\Identifiers\ModelId;
use PHPUnit\Framework\TestCase;

class ModelIdTest extends TestCase
{
    public function testCanInstantiate(): void
    {
        $modelId = new ModelId();
        self:: assertInstanceOf(Identifier::class, $modelId);
    }
}