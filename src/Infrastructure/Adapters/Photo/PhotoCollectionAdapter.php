<?php

declare(strict_types=1);

namespace AMSGuitars\Infrastructure\Adapters\Photo;

use AMSGuitars\Domain\Entities\Photo\Photo;
use AMSGuitars\Domain\ValueObjects\Collections\PhotoCollection;

class PhotoCollectionAdapter
{
    public static function fromArray(array $array): PhotoCollection
    {
        $photoCollection = new PhotoCollection();
        foreach($array as $photoArray) {
            $photo = PhotoAdapter::fromRow($photoArray);
            $photoCollection->add($photo);
        }
        return $photoCollection;
    }

    public static function toJson(PhotoCollection $photoCollection): string
    {
        $array = [];
        /** @var Photo $photo */
        foreach($photoCollection as $photo) {
            $array[] = $photo->toArray();
        }
        return json_encode($array);
    }
}