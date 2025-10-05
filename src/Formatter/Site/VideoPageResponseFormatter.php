<?php

declare(strict_types=1);

namespace App\Formatter\Site;

use App\Entity\Description;
use App\Entity\HasImageEntityInterface;
use App\Entity\Image;
use App\Entity\Slider;
use App\Formatter\Admin\ImageTrait;
use App\Helper\ConstantsHelper;
use phpDocumentor\Reflection\DocBlock\Tags\Formatter;
use Symfony\Component\Routing\RouterInterface;

final class VideoPageResponseFormatter
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

        $data['videos'] = $this->formatVideos($data['videos']);

        return $data;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function formatSlider(array $slider): array
    {
        $imageFilter = $slider['device'] === Image::DEVICE_MOBILE ? 'site_slider_mobile' : 'site_slider';

        $slider['description'] = explode(PHP_EOL, $slider['description'], 2);
        $slider['image_link'] = $this->router->generate('app.image_show', ['entity' => 'slider', 'name' => $slider['image'], 'filter' => $imageFilter]);
        $slider['position'] = ConstantsHelper::getConstantName((string)$slider['position'], 'POSITION', Slider::class);

        return $slider;
    }

    private function formatVideos(array $videos): array
    {
        return array_map(function ($item) {
            $item['image'] = $item['thumbnails']['high']['url'];

            return $item;
        }, $videos);
    }
}
