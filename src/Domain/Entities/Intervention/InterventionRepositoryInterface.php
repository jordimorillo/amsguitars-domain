<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\Entities\Intervention;

use AMSGuitars\Domain\ValueObjects\Collections\InterventionCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\InterventionId;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;

interface InterventionRepositoryInterface
{
    public function save(Intervention $intervention): void;
    public function findById(InterventionId $interventionId): Intervention;
    public function findCollection(SortOrder $sortOrder, Limit $limit = null): InterventionCollection;
}