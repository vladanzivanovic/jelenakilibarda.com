<?php

declare(strict_types=1);

namespace App\Formatter\Admin;

use App\Entity\Banner;
use App\Entity\Image;
use App\Repository\ImageRepository;
use Symfony\Component\Routing\RouterInterface;

final class BannerEditResponseFormatter
{
    use ImageTrait;

    private RouterInterface $router;

    private ImageRepository $imageRepository;

    public function __construct(
        RouterInterface $router,
        ImageRepository $imageRepository
    ) {
        $this->router = $router;
        $this->imageRepository = $imageRepository;
    }

    /**
     * @param Banner $banner
     *
     * @return array
     */
    public function formatResponse(Banner $banner): array
    {
        $images = $this->getImages($banner);

        $desktopImage = $this->imagesFormatter($this->router, [$images['desktop']], 'banner');

        $imagesArray = ['desktop' => $desktopImage];


        if (isset($images['mobile'])) {
            $imagesArray['mobile'] = $this->imagesFormatter($this->router, [$images['mobile']], 'banner');
        }

        return [
            'banner' => $banner,
            'selectedImages' => $imagesArray,
        ];
    }

    /**
     * @param Banner $banner
     *
     * @return array
     */
    private function getImages(Banner $banner): array
    {
        $image = $banner->getImage();
        $mobileImage = $this->imageRepository->findOneBy(['parentImage' => $image->getName(), 'device' => Image::DEVICE_MOBILE]);

        $images = [
            'desktop' => [
                'id' => $image->getId(),
                'fileName' => $image->getName(),
                'isMain' => $image->getIsMain(),
            ],
        ];

        if (null !== $mobileImage) {
            $images['mobile'] = [
                'id' => $mobileImage->getId(),
                'fileName' => $mobileImage->getName(),
                'isMain' => $mobileImage->getIsMain(),
            ];
        }

        return $images;
    }
}
