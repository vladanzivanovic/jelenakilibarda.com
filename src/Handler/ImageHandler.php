<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\EntityInterface;
use App\Entity\Image;
use App\Entity\ImageInterface;
use App\Entity\TranslatableInterface;
use App\Repository\ExtendedEntityRepository;
use App\Repository\HasImageRepositoryInterface;
use App\Repository\ImageRepository;
use App\Services\ImageService;
use Gedmo\Sluggable\Util\Urlizer;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Webmozart\Assert\Assert;

final class ImageHandler
{
    private ParameterBagInterface $bag;

    private ImageRepository $imageRepository;

    private LoggerInterface $logger;

    private ImageService $imageService;

    public function __construct(
        ParameterBagInterface $bag,
        ImageRepository $imageRepository,
        LoggerInterface $logger,
        ImageService $imageService
    ) {
        $this->bag = $bag;
        $this->imageRepository = $imageRepository;
        $this->logger = $logger;
        $this->imageService = $imageService;
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    public function setImages(
        EntityInterface $entity,
        array $data,
        ?ExtendedEntityRepository $hasImageRepository = null,
        int $device = Image::DEVICE_DESKTOP
    ): void {
        $rootDir = $this->bag->get('upload_dir');
        $tmpDir = $this->bag->get('upload_tmp_dir');
        $imageDir = $this->bag->get('upload_image_dir');

        if(empty(array_filter($data))) {
            return;
        }

        Assert::true($this->validateMainImage($data), 'field.main_image');

        $exceptions = [];

        foreach ($data as $index => $image) {
            if (isset($image['id'])) {
                $imageObj = $this->imageRepository->find($image['id']);

                if (null !== $hasImageRepository) {
                    $hasImage = $hasImageRepository->findOneBy(['entity' => $entity, 'image' => $imageObj]);
                }

                if(isset($image['deleted']) && true === $image['deleted']) {
                    $image['file'] = $rootDir.$imageDir.$imageObj->getOriginalName();
                    $file = $this->imageService->setFileObject($image);
                    $imageObj->setFile($file);
                    $imageObj->setIsDeleted(true);

                    try {
                        $file = $this->imageService->setFileObject($image);
                        $imageObj->setFile($file);
                        $imageObj->setIsDeleted(true);
                    } catch (FileNotFoundException $notFoundException) {
                        $this->logger->warning(
                            sprintf('File "%s" for ad "%s" has not been found.',
                                $imageObj->getName(),
                                $imageObj->getId()
                            ),
                            [
                                'message' => $notFoundException->getMessage(),
                                'file' => $notFoundException->getFile(),
                                'line' => $notFoundException->getLine(),
                                'code' => $notFoundException->getCode(),
                                'trace' => $notFoundException->getTraceAsString(),
                            ]
                        );
                    }

                    if (null !== $hasImageRepository) {
                        $hasImageRepository->delete($hasImage);
                    }

                    $this->imageRepository->delete($imageObj);

                    continue;
                }

                $imageObj->setIsMain($image['isMain']);

                continue;
            }

            try {
                $image['file'] = $rootDir.$tmpDir.$image['fileName'];
                $file = $this->imageService->setFileObject($image);
            } catch (FileNotFoundException $exception) {
                $exceptions[] = $image['fileName'];

                continue;
            }

            $mediaObj = new Image();

            $image['file'] = $rootDir.$tmpDir.$image['fileName'];

            if (!($file instanceof UploadedFile)) {
                continue;
            }

            $newName = md5($file->getFilename().Uuid::uuid4()->toString());

            $mediaObj->setRelatedToType(Image::RELATED_TYPE_PRODUCT);
            $mediaObj->setName($newName);
            $mediaObj->setIsmain($image['isMain']);
            $mediaObj->setOriginalName($newName.'.'.$file->guessExtension());
            $mediaObj->setFile($file);
            $mediaObj->setDevice($device);

            $this->imageRepository->persist($mediaObj);

            if (null !== $hasImageRepository && $entity instanceof ImageInterface) {
                $hasImages = $entity->createHasImage();
                $hasImages->setEntity($entity);
                $hasImages->setImage($mediaObj);

                $hasImageRepository->persist($hasImages);

                $entity->addHasImage($hasImages);
            } else {
            }
        }

        if (count($exceptions) > 0) {
            throw new BadRequestHttpException(json_encode(['images' => $exceptions]));
        }
    }

    private function validateMainImage(array $data): bool
    {
        foreach ($data as $image) {
            if (true === !!$image['isMain']) {
                return true;
            }
        }

        return false;
    }
}
