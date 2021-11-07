<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\Entities\Brand;

use AMSGuitars\Domain\Entities\Brand\Brand;
use AMSGuitars\Domain\ValueObjects\Collections\BrandCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\BrandId;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;

interface BrandRepositoryInterface
{
    public function save(Brand $brand): void;
    public function findById(BrandId $brandId): Brand;
    public function findCollection(SortOrder $sortOrder, Limit $limit = null): BrandCollection;
}