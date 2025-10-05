<?php

declare(strict_types=1);

namespace App\Collector\Site;

use App\Repository\ImageRepository;
use App\Repository\SliderRepository;

final class GalleryPageCollector
{
    use SliderTrait;

    private ImageRepository $repository;

    private SliderRepository $sliderRepository;

    private \Mobile_Detect $detector;

    public function __construct(
        ImageRepository $repository,
        SliderRepository $sliderRepository
    ) {
        $this->sliderRepository = $sliderRepository;
        $this->detector = new \Mobile_Detect();
        $this->repository = $repository;
    }

    /**
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function collect(string $locale): array
    {
        return [
            'slider' => $this->getSlider($this->sliderRepository, $locale, $this->detector, 'gallery'),
            'images' => $this->repository->getCatalogImages(),
        ];
    }
}
