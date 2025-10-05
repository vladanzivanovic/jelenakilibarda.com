<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\EntityInterface;
use App\Entity\ImageInterface;
use App\Services\ImageService;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class BaseRemoveHandler
{
    private ImageService $imageService;

    private ParameterBagInterface $bag;

    private ObjectManager $objectManager;

    public function __construct(
        ImageService $imageService,
        ParameterBagInterface $bag,
        ObjectManager $objectManager
    ) {
        $this->imageService = $imageService;
        $this->bag = $bag;
        $this->objectManager = $objectManager;
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove(EntityInterface $entity): void
    {
        $rootDir = $this->bag->get('upload_dir');
        $imageDir = $this->bag->get('upload_image_dir');

        if ($entity instanceof ImageInterface) {
            $images = $entity->getHasImages();

            foreach ($images as $image) {
                $image->setFile($this->imageService->setFileObject(['file' => $rootDir . $imageDir . $image->getOriginalName(), 'fileName' => $image->getOriginalName()]));
                $image->setIsDeleted(true);
            }
        }

        $this->objectManager->remove($entity);

        $this->objectManager->flush();
    }
}
