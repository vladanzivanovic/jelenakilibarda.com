<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Description;
use App\Entity\EntityInterface;
use App\Entity\HasImageEntityInterface;
use App\Entity\Slider;
use App\Helper\ValidatorHelper;
use App\Repository\DescriptionRepository;
use App\Repository\ImageRepository;
use App\Repository\SliderRepository;
use App\Services\ImageService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class DescriptionHandler
{
    private DescriptionRepository $descriptionRepository;

    private ValidatorHelper $validator;

    private ImageService $imageService;

    private ParameterBagInterface $bag;

    public function __construct(
        DescriptionRepository $descriptionRepository,
        ValidatorHelper       $validator,
        ImageService          $imageService,
        ParameterBagInterface $bag
    ) {
        $this->descriptionRepository = $descriptionRepository;
        $this->validator = $validator;
        $this->imageService = $imageService;
        $this->bag = $bag;
    }

    /**
     * @param EntityInterface $entity
     *
     * @return void
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(EntityInterface $entity): void
    {
        $errors = $this->validator->validate($entity, null, "SetDescription");

        if ($errors->count() > 0) {
            throw new UnprocessableEntityHttpException(json_encode($this->validator->parseErrors($errors)));
        }

        if (null === $entity->getId()) {
            $this->descriptionRepository->persist($entity);
        }

        $this->descriptionRepository->flush();
    }

    /**
     * @param Slider $slider
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Description $description): void
    {
        $rootDir = $this->bag->get('upload_dir');
        $imageDir = $this->bag->get('upload_image_dir');

        $hasImages = $description->getHasImages();

        if (0 < $hasImages->count()) {
            /** @var HasImageEntityInterface $hasImage */
            foreach ($hasImages->getIterator() as $hasImage) {
                $image = $hasImage->getImage();

                $image->setFile($this->imageService->setFileObject(['file' => $rootDir . $imageDir . $image->getOriginalName(), 'fileName' => $image->getOriginalName()]));
                $image->setIsDeleted(true);
            }
        }

        $this->descriptionRepository->delete($description);

        $this->descriptionRepository->flush();
    }
}
