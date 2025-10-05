<?php

declare(strict_types=1);

namespace App\Formatter\Admin;

use App\Repository\ImageRepository;
use Symfony\Component\Routing\RouterInterface;

final class CatalogResponseFormatter
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

    public function formatResponse(): array
    {
        return [
            'selectedImages' => $this->imagesFormatter(
                $this->router,
                $this->imageRepository->getCatalogImages(),
                'catalog'
            ),
        ];
    }
}
