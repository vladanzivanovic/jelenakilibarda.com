<?php

declare(strict_types=1);

namespace App\Formatter\Site;

use App\Formatter\Admin\ImageTrait;
use Symfony\Component\Routing\RouterInterface;

final class GalleryBaseFormatter
{
    use ImageTrait;

    private RouterInterface $router;

    public function __construct(
        RouterInterface $router
    ) {
        $this->router = $router;
    }
    public function getGallery(
        array $images,
        string $entityName
    ): array {
        $images =

        $fullSizeImages = $this->imagesFormatter(
            $this->router,
            $images,
            $entityName,
            'gallery_full_image'
        );

        $thumbSizeImages = $this->imagesFormatter(
            $this->router,
            $images,
            $entityName,
            'gallery_thumbnails_image'
        );

        $formattedImages = [];

        foreach ($fullSizeImages as $index => $fullSizeImage) {
            $fullSizeImage['thumb_image'] = $thumbSizeImages[$index]['file'];

            $formattedImages[] = $fullSizeImage;
        }

        return $formattedImages;
    }
}
