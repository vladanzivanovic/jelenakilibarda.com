<?php

declare(strict_types=1);

namespace App\Collector\Site;

use App\Repository\BiographyRepository;
use App\Repository\SettingsRepository;
use App\Repository\SliderRepository;

final class ContactPageCollector
{
    use SliderTrait;

    private SliderRepository $sliderRepository;

    private \Mobile_Detect $detector;

    private SettingsRepository $settingsRepository;

    public function __construct(
        SettingsRepository $settingsRepository,
        SliderRepository $sliderRepository
    ) {
        $this->sliderRepository = $sliderRepository;
        $this->detector = new \Mobile_Detect();
        $this->settingsRepository = $settingsRepository;
    }

    /**
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function collect(string $locale): array
    {
        return [
            'slider' => $this->getSlider($this->sliderRepository, $locale, $this->detector, 'contact'),
            'settings' => $this->settingsRepository->getSettingsForContactPage(),
        ];
    }
}
