<?php

declare(strict_types=1);

namespace App\Formatter\Admin;

use App\Entity\Image;
use App\Entity\Slider;
use App\Entity\SliderHasImages;
use App\Helper\ConstantsHelper;
use App\Repository\ImageRepository;
use Symfony\Component\Routing\RouterInterface;

final class SliderEditResponseFormatter
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
     * @return array<string, mixed>
     */
    public function formatResponse(Slider $slider): array
    {
        $images = $this->imageRepository->getByMainEntity($slider, SliderHasImages::class);
        $imagesByDevice = [];

        foreach ($images as $image) {
            $deviceName = ConstantsHelper::getConstantName((string) $image['device'], 'DEVICE', Image::class);

            $imagesByDevice[$deviceName][] = $image;
        }

        foreach ($imagesByDevice as $device => $items) {
            $selectedImages[$device] = $this->imagesFormatter(
                $this->router,
                $items,
                'slider'
            );
        }

        return [
            'slider' => $slider,
            'selectedImages' => $selectedImages,
        ];
    }
}
