<?php

declare(strict_types=1);

namespace App\Formatter\Site;

use App\Entity\Image;
use App\Entity\Slider;
use App\Helper\ConstantsHelper;
use Symfony\Component\Routing\RouterInterface;

final class HomePageResponseFormatter
{
    private RouterInterface $router;


    public function __construct(
        RouterInterface $router
    ) {
        $this->router = $router;
    }

    /**
     * @param array $data
     *
     * @return array
     * @throws \ReflectionException
     */
    public function formatResponse(array $data): array
    {
        if (null !== $data['slider']) {
            $data['slider'] = $this->formatSlider($data['slider']);
        }

        return $data;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function formatSlider(array $slider): array
    {
        $imageFilter = $slider['device'] === Image::DEVICE_MOBILE ? 'site_slider_mobile' : 'site_slider';

        $slider['description'] = explode(PHP_EOL, $slider['description'], 3);
        $slider['image_link'] = $this->router->generate('app.image_show', ['entity' => 'slider', 'name' => $slider['image'], 'filter' => $imageFilter]);
        $slider['position'] = ConstantsHelper::getConstantName((string)$slider['position'], 'POSITION', Slider::class);

        return $slider;
    }
}
