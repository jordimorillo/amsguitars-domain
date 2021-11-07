<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects\Collections;

use AMSGuitars\Domain\Entities\Intervention\Intervention;
use Ramsey\Collection\Collection;

class InterventionCollection extends Collection implements JsonValueObject
{
    public function __construct(array $interventions = [])
    {
        parent::__construct(Intervention::class, $interventions);
    }

    public function toIdentifiersJson(): string
    {
        $interventionIds = [];
        /** @var Intervention $intervention */
        foreach($this->getIterator() as $intervention) {
            $interventionIds[] = $intervention->getInterventionId()->toString();
        }
        return json_encode($interventionIds);
    }

    public function toJson(): string
    {
        $interventions = [];
        /** @var Intervention $intervention */
        foreach($this->getIterator() as $intervention) {
            $interventions[] = $intervention->toArray();
        }
        return json_encode($interventions);
    }
}