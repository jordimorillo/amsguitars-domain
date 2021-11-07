<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\Entities\Guitar;

use AMSGuitars\Domain\Entities\Guitar\Guitar;
use AMSGuitars\Domain\ValueObjects\Collections\GuitarCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\GuitarId;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;

interface GuitarRepositoryInterface
{
    public function save(Guitar $guitar): void;
    public function findById(GuitarId $guitarId): Guitar;
    public function findCollection(SortOrder $order, Limit $limit = null): GuitarCollection;
}