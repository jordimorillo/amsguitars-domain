<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Adapters\Guitar;

use AMSGuitars\Domain\ValueObjects\Collections\GuitarCollection;

class GuitarCollectionAdapter
{
    public static function fromRows(array $rows): GuitarCollection
    {
        $guitarCollection = new GuitarCollection();
        foreach($rows as $guitarRow) {
            $guitar = GuitarAdapter::fromRow($guitarRow);
            $guitarCollection->add($guitar);
        }
        return $guitarCollection;
    }
}