<?php

namespace AMSGuitars\Domain\ValueObjects\Collections;

use AMSGuitars\Domain\Entities\Model\Model;
use Ramsey\Collection\Collection;

class ModelCollection extends Collection implements JsonValueObject
{
    /** @param Model[] $persons */
    public function __construct(array $persons = [])
    {
        parent::__construct(Model::class, $persons);
    }

    public function toIdentifiersJson(): string
    {
        $models = [];
        /** @var Model $model */
        foreach($this->getIterator() as $model) {
            $models[] = $model->getModelId()->toString();
        }
        return json_encode($models);
    }

    public function toJson(): string
    {
        $models = [];
        /** @var Model $model */
        foreach($this->getIterator() as $model) {
            $models[] = $model->toArray();
        }
        return json_encode($models);
    }
}