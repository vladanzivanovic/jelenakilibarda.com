<?php

declare(strict_types=1);

namespace App\Collector\Site;

use App\Repository\DescriptionHasImagesRepository;
use App\Repository\DescriptionRepository;
use App\Repository\SliderRepository;

final class DescriptionPageCollector
{
    use SliderTrait;

    private DescriptionRepository $descriptionRepository;

    private SliderRepository $sliderRepository;

    private \Mobile_Detect $detector;

    private DescriptionHasImagesRepository $hasImagesRepository;

    public function __construct(
        DescriptionRepository $descriptionRepository,
        SliderRepository $sliderRepository,
        DescriptionHasImagesRepository $hasImagesRepository
    ) {
        $this->descriptionRepository = $descriptionRepository;
        $this->sliderRepository = $sliderRepository;
        $this->detector = new \Mobile_Detect();
        $this->hasImagesRepository = $hasImagesRepository;
    }

    /**
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function collect(string $locale, string $type): array
    {
        $description = $this->descriptionRepository->getByLocaleAndType($locale, $type);

        $data = [
            'slider' => $this->getSlider($this->sliderRepository, $locale, $this->detector, 'biography'),
            'biography' => $description,
            'images' => [],
        ];


        if(0 < $description['has_images']) {
            $data['images'] = $this->hasImagesRepository->getDescriptionImagesByDescriptionId($description['id']);
        }

        return $data;
    }
}
