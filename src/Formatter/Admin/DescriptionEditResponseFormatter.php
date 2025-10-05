<?php

declare(strict_types=1);

namespace App\Formatter\Admin;

use App\Entity\Description;
use App\Entity\DescriptionHasImages;
use App\Repository\ImageRepository;
use Symfony\Component\Routing\RouterInterface;

final class DescriptionEditResponseFormatter
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
     * @return array
     */
    public function formatResponse(Description $description): array
    {
        $data = [
            'description' => $description,
            'selectedImages' => [],
        ];

        if (0 < $description->getHasImages()->count()) {
            $data['selectedImages'] = $this->imagesFormatter(
                $this->router,
                $this->imageRepository->getByMainEntity($description, DescriptionHasImages::class),
                'description'
            );
        }

        return $data;
    }
}
