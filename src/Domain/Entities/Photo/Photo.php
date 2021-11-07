<?php

declare(strict_types=1);

namespace AMSGuitars\Domain\Entities\Photo;

use AMSGuitars\Domain\Entities\Entity;
use AMSGuitars\Domain\ValueObjects\Identifiers\PhotoId;
use AMSGuitars\Domain\ValueObjects\Title;
use AMSGuitars\Infrastructure\ValueObjects\Filesystem\Path;

class Photo implements Entity
{
    public PhotoId $photoId;
    public Title $title;
    private Path $pathToFileInLinux;

    public function __construct(PhotoId $photoId, Title $title, Path $pathToFileInLinux) {
        $this->photoId = $photoId;
        $this->title = $title;
        $this->pathToFileInLinux = $pathToFileInLinux;
    }

    public function getPhotoId(): PhotoId
    {
        return $this->photoId;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getPathToFileInLinux(): Path
    {
        return $this->pathToFileInLinux;
    }

    public function toArray(): array
    {
        return [
            'photoId' => $this->getPhotoId()->toString(),
            'title' => $this->getTitle()->toString(),
            'pathToFileInLinux' => $this->getPathToFileInLinux()->toString(),
        ];
    }
}