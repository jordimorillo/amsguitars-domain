<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\Entities\Person;

use AMSGuitars\Domain\ValueObjects\Collections\PersonCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\PersonId;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;

interface PersonRepositoryInterface
{
    public function save(Person $person): void;
    public function findById(PersonId $personId): Person;
    public function findCollection(SortOrder $sortOrder, Limit $limit = null): PersonCollection;
}