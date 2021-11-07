<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects\Collections;

use AMSGuitars\Domain\Entities\Guitar\Guitar;
use Ramsey\Collection\Collection;

class GuitarCollection extends Collection implements JsonValueObject
{
    /** @param Guitar[] $elements */
    public function __construct(array $elements = [])
    {
        parent::__construct(Guitar::class, $elements);
    }

    public function toIdentifiersJson(): string
    {
        $guitarIds = [];
        /** @var Guitar $guitar */
        foreach($this->getIterator() as $guitar) {
            $guitarIds[] = $guitar->getGuitarId()->toString();
        }
        return json_encode($guitarIds);
    }

    public function toJson(): string
    {
        $guitars = [];
        /** @var Guitar $guitar */
        foreach($this->getIterator() as $guitar) {
            $guitars[] = $guitar->toArray();
        }
        return json_encode($guitars);
    }
}