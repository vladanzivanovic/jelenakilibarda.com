<?php

declare(strict_types=1);

namespace App\Formatter\Admin;

use App\Entity\Banner;
use App\Entity\Description;
use App\Entity\DescriptionHasImages;
use App\Entity\Image;
use App\Repository\BiographyRepository;
use App\Repository\ImageRepository;
use Symfony\Component\Routing\RouterInterface;

final class BiographyResponseFormatter
{
    use ImageTrait;

    private RouterInterface $router;

    private ImageRepository $imageRepository;

    private BiographyRepository $biographyRepository;

    public function __construct(
        RouterInterface $router,
        ImageRepository $imageRepository,
        DescriptionRepository $biographyRepository
    ) {
        $this->router = $router;
        $this->imageRepository = $imageRepository;
        $this->biographyRepository = $biographyRepository;
    }

    /**
     * @return array<string, mixed>
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function formatResponse(): array
    {
        $biography = $this->biographyRepository->getByType();

        $data = ['biography' => $biography];

        if (null !== $biography) {
            $data['selectedImages'] = $this->imagesFormatter(
                $this->router,
                $this->imageRepository->getByMainEntity($biography, DescriptionHasImages::class),
                'biography'
            );
        }

        return $data;
    }
}
