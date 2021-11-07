<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\Entities\Intervention;

use AMSGuitars\Domain\Entities\Entity;
use AMSGuitars\Domain\ValueObjects\Collections\PhotoCollection;
use AMSGuitars\Domain\ValueObjects\Comments;
use AMSGuitars\Domain\ValueObjects\Diagnostic;
use AMSGuitars\Domain\ValueObjects\Identifiers\InterventionId;
use AMSGuitars\Domain\ValueObjects\InterventionStatus;

class Intervention implements Entity
{
    public InterventionId $interventionId;
    private PhotoCollection $photoCollection;
    private Diagnostic $diagnostic;
    private Comments $comments;
    public InterventionStatus $interventionStatus;

    public function __construct(
        InterventionId $interventionId,
        InterventionStatus $interventionStatus,
        Diagnostic $diagnostic,
        Comments $comments,
        PhotoCollection $photoCollection
    ) {
        $this->interventionId = $interventionId;
        $this->interventionStatus = $interventionStatus;
        $this->diagnostic = $diagnostic;
        $this->comments = $comments;
        $this->photoCollection = $photoCollection;
    }

    public function getInterventionId(): InterventionId
    {
        return $this->interventionId;
    }

    public function getInterventionStatus(): InterventionStatus
    {
        return $this->interventionStatus;
    }

    public function getDiagnostic(): Diagnostic
    {
        return $this->diagnostic;
    }

    public function getComments(): Comments
    {
        return $this->comments;
    }

    public function getPhotoCollection(): PhotoCollection
    {
        return $this->photoCollection;
    }

    public function received(): void
    {
        $this->interventionStatus = InterventionStatus::RECEIVED();
    }

    public function diagnosed(): void
    {
        $this->interventionStatus = InterventionStatus::DIAGNOSED();
    }

    public function underRepair(): void
    {
        $this->interventionStatus = InterventionStatus::UNDER_REPAIR();
    }

    public function waitingForMaterial(): void
    {
        $this->interventionStatus = InterventionStatus::WAITING_FOR_MATERIAL();
    }

    public function waitingToDeliver(): void
    {
        $this->interventionStatus = InterventionStatus::WAITING_TO_DELIVER();
    }

    public function delivered(): void
    {
        $this->interventionStatus = InterventionStatus::DELIVERED();
    }

    public function cancelled(): void
    {
        $this->interventionStatus = InterventionStatus::CANCELLED();
    }

    public function toArray(): array
    {
        return [
            'interventionId' => $this->getInterventionId()->toString(),
            'interventionStatus' => $this->getInterventionStatus()->toString(),
            'diagnostic' => $this->getDiagnostic()->toString(),
            'comments' => $this->getComments()->toString(),
            'photoCollection' => $this->getPhotoCollection()->toIdentifiersJson(),
        ];
    }
}