<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects\Collections;

use AMSGuitars\Domain\Entities\Person\Person;
use Ramsey\Collection\Collection;

class PersonCollection extends Collection implements JsonValueObject
{
    /** @param Person[] $persons */
    public function __construct(array $persons = [])
    {
        parent::__construct(Person::class, $persons);
    }

    public function toIdentifiersJson(): string
    {
        $persons = [];
        /** @var Person $person */
        foreach($this->getIterator() as $person) {
            $persons[] = $person->getPersonId()->toString();
        }
        return json_encode($persons);
    }

    public function toJson(): string
    {
        $persons = [];
        /** @var Person $person */
        foreach($this->getIterator() as $person) {
            $persons[] = $person->toArray();
        }
        return json_encode($persons);
    }
}