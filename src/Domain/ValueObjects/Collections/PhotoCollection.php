<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\ValueObjects\Collections;

use AMSGuitars\Domain\Entities\Photo\Photo;
use Ramsey\Collection\Collection;

class PhotoCollection extends Collection implements JsonValueObject
{
    /** @param Photo[] $persons */
    public function __construct(array $persons = [])
    {
        parent::__construct(Photo::class, $persons);
    }

    public function toIdentifiersJson(): string
    {
        $photos = [];
        /** @var Photo $photo */
        foreach($this->getIterator() as $photo) {
            $photos[] = $photo->getPhotoId()->toString();
        }
        return json_encode($photos);
    }

    public function toJson(): string
    {
        $photos = [];
        /** @var Photo $photo */
        foreach($this->getIterator() as $photo) {
            $photos[] = $photo->toArray();
        }
        return json_encode($photos);
    }
}