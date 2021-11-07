<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Persistence\PersonRepository;

use AMSGuitars\Domain\Entities\Person\Person;
use AMSGuitars\Domain\Entities\Person\PersonRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\PersonCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\PersonId;
use AMSGuitars\Infrastructure\Exceptions\PersonNotFound;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;

class PersonRepositoryInMemory implements PersonRepositoryInterface
{
    private PersonCollection $personCollection;

    public function __construct(PersonCollection $personCollection = null)
    {
        $this->personCollection = $personCollection ?? new PersonCollection();
    }

    public function save(Person $person): void
    {
        $this->personCollection->add($person);
    }

    public function findById(PersonId $personId): Person
    {
        /** @var Person $person */
        foreach($this->personCollection->getIterator() as $person) {
            if($person->getPersonId() === $personId) {
                return $person;
            }
        }

        throw new PersonNotFound('Order with ID '.$personId.' does not exist');
    }

    public function findCollection(SortOrder $sortOrder, Limit $limit = null): PersonCollection
    {
        $personCollection = new PersonCollection();
        $personCollection->sort($sortOrder->getColumn()->toString(), $sortOrder->getSortDirection()->getValue());

        if($limit !== null) {
            $startPosition = $limit->getOffset() * $limit->getTotalItems();
            foreach($this->personCollection->getIterator() as $key => $intervention) {
                if($key > $startPosition && $key <= $startPosition + $limit->getTotalItems()) {
                    $personCollection->add($intervention);
                }
            }
        } else {
            $personCollection = $this->personCollection;
        }

        return $personCollection;
    }
}