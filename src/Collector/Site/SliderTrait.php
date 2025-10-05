<?php

namespace App\Collector\Site;

use App\Entity\Image;
use App\Repository\SliderRepository;

trait SliderTrait
{
    /**
     * @return array|null
     */
    private function getSlider(
        SliderRepository $sliderRepository,
        string $locale,
        \Mobile_Detect $mobileDetect,
        string $page
    ): ?array {
        $device = Image::DEVICE_DESKTOP;

        if ($mobileDetect->isMobile() || $mobileDetect->isTablet()) {
            $device = Image::DEVICE_MOBILE;
        }

        return $sliderRepository->getActiveSliderByPage($locale, $device, $page);;
    }
}
