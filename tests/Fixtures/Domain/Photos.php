<?php

declare(strict_types=1);

namespace Tests\Fixtures\Domain;

use AMSGuitars\Domain\Entities\Photo\Photo;
use AMSGuitars\Domain\ValueObjects\Identifiers\PhotoId;
use AMSGuitars\Domain\ValueObjects\Title;
use AMSGuitars\Infrastructure\ValueObjects\Filesystem\Path;

class Photos extends FakeEntityGenerator
{
    public function aPhoto(): Photo
    {
        return new Photo(
            new PhotoId(),
            new Title($this->faker->title),
            new Path('/var/www/html/example.jpg')
        );
    }
}