<?php

declare(strict_types=1);

namespace Tests\Fixtures\Domain;

use AMSGuitars\Domain\Entities\Intervention\Intervention;
use AMSGuitars\Domain\ValueObjects\Identifiers\InterventionId;
use AMSGuitars\Domain\ValueObjects\Collections\PhotoCollection;
use AMSGuitars\Domain\ValueObjects\Comments;
use AMSGuitars\Domain\ValueObjects\Diagnostic;
use AMSGuitars\Domain\ValueObjects\Identifiers\OrderId;
use AMSGuitars\Domain\ValueObjects\InterventionStatus;

class Interventions extends FakeEntityGenerator
{
    public function anIntervention(): Intervention
    {
        return new Intervention(
            new InterventionId(),
            new OrderId(),
            InterventionStatus::RECEIVED(),
            new Diagnostic($this->faker->text),
            new Comments($this->faker->text),
            new PhotoCollection()
        );
    }
}