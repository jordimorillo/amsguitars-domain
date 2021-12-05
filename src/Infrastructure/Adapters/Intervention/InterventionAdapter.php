<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Adapters\Intervention;

use AMSGuitars\Domain\Entities\Intervention\Intervention;
use AMSGuitars\Domain\ValueObjects\Comments;
use AMSGuitars\Domain\ValueObjects\Diagnostic;
use AMSGuitars\Domain\ValueObjects\Identifiers\InterventionId;
use AMSGuitars\Domain\ValueObjects\Identifiers\OrderId;
use AMSGuitars\Domain\ValueObjects\InterventionStatus;
use AMSGuitars\Infrastructure\Adapters\Photo\PhotoCollectionAdapter;

class InterventionAdapter
{
    public static function fromRow(array $interventionRow): Intervention
    {
        return new Intervention(
            new InterventionId($interventionRow['interventionId']),
            new OrderId($interventionRow['orderId']),
            InterventionStatus::from($interventionRow['interventionStatus']),
            new Diagnostic($interventionRow['diagnostic']),
            new Comments($interventionRow['comments']),
            PhotoCollectionAdapter::fromArray($interventionRow['photoCollection'])
        );
    }
}