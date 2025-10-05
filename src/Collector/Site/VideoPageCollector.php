<?php

declare(strict_types=1);

namespace App\Collector\Site;

use App\Repository\SliderRepository;
use App\Repository\VideoRepository;

final class VideoPageCollector
{
    use SliderTrait;

    private VideoRepository $videoRepository;

    private SliderRepository $sliderRepository;

    private \Mobile_Detect $detector;

    public function __construct(
        VideoRepository $videoRepository,
        SliderRepository $sliderRepository
    ) {
        $this->sliderRepository = $sliderRepository;
        $this->detector = new \Mobile_Detect();
        $this->videoRepository = $videoRepository;
    }

    /**
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function collect(string $locale): array
    {
        return [
            'slider' => $this->getSlider($this->sliderRepository, $locale, $this->detector, 'gallery'),
            'videos' => $this->videoRepository->getVideos($locale),
        ];
    }
}
