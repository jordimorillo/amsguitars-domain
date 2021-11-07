<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Persistence\ModelRepository;

use AMSGuitars\Domain\Entities\Model\Model;
use AMSGuitars\Domain\Entities\Model\ModelRepositoryInterface;
use AMSGuitars\Domain\ValueObjects\Collections\ModelCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\ModelId;
use AMSGuitars\Infrastructure\Exceptions\ModelNotFound;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\Limit;
use AMSGuitars\Infrastructure\ValueObjects\Persistence\SortOrder;

class ModelRepositoryInMemory implements ModelRepositoryInterface
{
    private ModelCollection $modelCollection;

    public function __construct(ModelCollection $modelCollection = null)
    {
        $this->modelCollection = $modelCollection ?? new ModelCollection();
    }

    public function save(Model $model): void
    {
        $this->modelCollection->add($model);
    }

    public function findById(ModelId $modelId): Model
    {
        /** @var Model $model */
        foreach($this->modelCollection->getIterator() as $model) {
            if($model->getModelId() === $modelId) {
                return $model;
            }
        }

        throw new ModelNotFound('Model with ID '.$modelId.' does not exist');
    }

    public function findCollection(SortOrder $sortOrder, Limit $limit = null): ModelCollection
    {
        $modelCollection = new ModelCollection();
        $modelCollection->sort($sortOrder->getColumn()->toString(), $sortOrder->getSortDirection()->getValue());

        if($limit !== null) {
            $startPosition = $limit->getOffset() * $limit->getTotalItems();
            foreach($this->modelCollection->getIterator() as $key => $intervention) {
                if($key > $startPosition && $key <= $startPosition + $limit->getTotalItems()) {
                    $modelCollection->add($intervention);
                }
            }
        } else {
            $modelCollection = $this->modelCollection;
        }

        return $modelCollection;
    }
}