<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Adapters\Guitar;

use AMSGuitars\Domain\Entities\Guitar\Guitar;
use AMSGuitars\Domain\ValueObjects\Identifiers\GuitarId;
use AMSGuitars\Domain\ValueObjects\Identifiers\ModelId;
use AMSGuitars\Domain\ValueObjects\Identifiers\PersonId;
use AMSGuitars\Infrastructure\Adapters\Intervention\InterventionCollectionAdapter;

class GuitarAdapter
{
    public static function fromRow(array $guitarRow): Guitar
    {
        return new Guitar(
            new GuitarId($guitarRow['guitarId']),
            new PersonId($guitarRow['personId']),
            new ModelId($guitarRow['modelId']),
            InterventionCollectionAdapter::fromRow(json_decode($guitarRow['interventionCollection'], true))
        );
    }
}