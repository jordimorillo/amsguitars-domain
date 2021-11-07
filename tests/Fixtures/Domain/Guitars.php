<?php

declare(strict_types=1);

namespace Tests\Fixtures\Domain;

use AMSGuitars\Domain\ValueObjects\Identifiers\BrandId;
use AMSGuitars\Domain\Entities\Guitar\Guitar;
use AMSGuitars\Domain\ValueObjects\Identifiers\GuitarId;
use AMSGuitars\Domain\ValueObjects\Collections\InterventionCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\ModelId;
use AMSGuitars\Domain\ValueObjects\Identifiers\PersonId;
use AMSGuitars\Domain\ValueObjects\Collections\PhotoCollection;

class Guitars extends FakeEntityGenerator
{
    public function aGuitar(): Guitar
    {
        $photos = new Photos();
        return new Guitar(
            new GuitarId(),
            new PersonId(),
            new ModelId(),
            new PhotoCollection(
                [
                    $photos->aPhoto()
                ]
            ),
            new InterventionCollection()
        );
    }
}