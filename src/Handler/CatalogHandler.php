<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Catalogue;
use App\Helper\ValidatorHelper;
use App\Repository\CatalogueRepository;
use App\Repository\ImageRepository;
use App\Services\ImageService;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class CatalogHandler
{
    private ValidatorHelper $validator;

    private ImageRepository $imageRepository;

    public function __construct(
        ValidatorHelper $validator,
        ImageRepository $imageRepository
    ) {
        $this->validator = $validator;
        $this->imageRepository = $imageRepository;
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception
     */
    public function save(array $images): void
    {
        $errors = $this->validator->validate($images, null, "SetImages");

        if ($errors->count() > 0) {
            throw new UnprocessableEntityHttpException(json_encode($this->validator->parseErrors($errors)));
        }

        $this->imageRepository->flush();
    }

//    /**
//     * @param Catalogue $catalogue
//     *
//     * @throws \Doctrine\ORM\ORMException
//     * @throws \Doctrine\ORM\OptimisticLockException
//     */
//    public function remove(Catalogue $catalogue): void
//    {
//        $this->catalogueRepository->delete($catalogue);
//        $this->catalogueRepository->flush();
//    }
}
