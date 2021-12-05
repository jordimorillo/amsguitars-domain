<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Adapters\Photo;

use AMSGuitars\Domain\Entities\Photo\Photo;
use AMSGuitars\Domain\ValueObjects\Identifiers\PhotoId;
use AMSGuitars\Domain\ValueObjects\StringValueObject;
use AMSGuitars\Domain\ValueObjects\Title;
use AMSGuitars\Infrastructure\ValueObjects\Filesystem\Path;

class PhotoAdapter
{
    public static function fromRow(array $row): Photo
    {
        return new Photo(
            new PhotoId($row['photoId']),
            new Title($row['title']),
            new Path($row['path'])
        );
    }

    public static function toJson(Photo $photo): string
    {
        return json_encode($photo->toArray());
    }
}