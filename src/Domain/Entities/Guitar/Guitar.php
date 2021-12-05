<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\Entities\Guitar;

use AMSGuitars\Domain\Entities\Entity;
use AMSGuitars\Domain\ValueObjects\Collections\InterventionCollection;
use AMSGuitars\Domain\ValueObjects\Collections\PhotoCollection;
use AMSGuitars\Domain\ValueObjects\Identifiers\GuitarId;
use AMSGuitars\Domain\ValueObjects\Identifiers\ModelId;
use AMSGuitars\Domain\ValueObjects\Identifiers\PersonId;

class Guitar implements Entity
{
    public GuitarId $guitarId;
    public PersonId $personId;
    public ModelId $modelId;
    private InterventionCollection $interventionCollection;

    public function __construct(
        GuitarId $guitarId,
        PersonId $personId,
        ModelId $modelId,
        InterventionCollection $interventionCollection
    ) {
        $this->guitarId = $guitarId;
        $this->personId = $personId;
        $this->modelId = $modelId;
        $this->interventionCollection = $interventionCollection;
    }

    public function getGuitarId(): GuitarId
    {
        return $this->guitarId;
    }

    public function getPersonId(): PersonId
    {
        return $this->personId;
    }

    public function getModelId(): ModelId
    {
        return $this->modelId;
    }

    public function getInterventionCollection(): InterventionCollection
    {
        return $this->interventionCollection;
    }

    public function toArray(): array
    {
        return [
            'guitarId' => $this->getGuitarId()->toString(),
            'personId' => $this->getPersonId()->toString(),
            'modelId' => $this->getModelId()->toString(),
            'interventionCollection' => $this->getInterventionCollection()->toIdentifiersJson(),
        ];
    }
}