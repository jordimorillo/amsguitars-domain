<?php

declare(strict_types=1);

namespace Tests\Fixtures\Domain;

use AMSGuitars\Domain\Entities\Guitar\Guitar;
use AMSGuitars\Domain\ValueObjects\Collections\InterventionCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\GuitarId;
use AMSGuitars\Domain\ValueObjects\Identifiers\ModelId;
use AMSGuitars\Domain\ValueObjects\Identifiers\PersonId;

class Guitars extends FakeEntityGenerator
{
    public function aGuitar(): Guitar
    {
        return new Guitar(
            new GuitarId(),
            new PersonId(),
            new ModelId(),
            new InterventionCollection()
        );
    }
}