<?php

declare(strict_types=1);

namespace App\Parser;

use App\Services\CatalogImageService;
use Symfony\Component\HttpFoundation\ParameterBag;

final class CatalogEditRequestParser
{
    use ParserTrait;

    private CatalogImageService $imageService;

    public function __construct(
        CatalogImageService $imageService
    ) {
        $this->imageService = $imageService;
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    public function parse(ParameterBag $bag): array
    {
        return $this->imageService->setImages(json_decode($bag->get('images'), true));
    }
}
