<?php

declare(strict_types=1);

namespace App\Collector\Site;

use App\Repository\SliderRepository;

final class HomePageCollector
{
    use SliderTrait;

    private SliderRepository $sliderRepository;

    private \Mobile_Detect $detector;

    public function __construct(
        SliderRepository      $sliderRepository
    ) {
        $this->sliderRepository = $sliderRepository;
        $this->detector = new \Mobile_Detect();
    }

    /**
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function collect(string $locale): array
    {
        return [
            'slider' => $this->getSlider($this->sliderRepository, $locale, $this->detector, 'home'),
        ];
    }
}
