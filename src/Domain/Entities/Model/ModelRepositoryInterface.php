<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\Entities\Model;

use AMSGuitars\Domain\Entities\Model\Model;
use AMSGuitars\Domain\ValueObjects\Collections\ModelCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\ModelId;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;

interface ModelRepositoryInterface
{
    public function save(Model $model): void;
    public function findById(ModelId $modelId): Model;
    public function findCollection(SortOrder $sortOrder, Limit $limit = null): ModelCollection;
}