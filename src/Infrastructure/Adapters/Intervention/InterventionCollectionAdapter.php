<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Adapters\Intervention;

use AMSGuitars\Domain\ValueObjects\Collections\InterventionCollection;

class InterventionCollectionAdapter
{
    public static function fromRow(array $array): InterventionCollection
    {
        $interventionCollection = new InterventionCollection();
        foreach($array as $interventionRow) {
            $intervention = InterventionAdapter::fromRow($interventionRow);
            $interventionCollection->add($intervention);
        }
        return $interventionCollection;
    }
}