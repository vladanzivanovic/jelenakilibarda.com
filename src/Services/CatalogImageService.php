<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Webmozart\Assert\Assert;

final class CatalogImageService
{
    use ImageServiceTrait;

    protected ImageService $imageService;

    private ImageRepository $imageRepository;

    private ParameterBagInterface $bag;

    public function __construct(
        ImageService $imageService,
        ParameterBagInterface $bag,
        ImageRepository $imageRepository
    ) {
        $this->imageService = $imageService;
        $this->imageRepository = $imageRepository;
        $this->bag = $bag;
    }

    public function setImages(array $data): array
    {
        $rootDir = $this->bag->get('upload_dir');
        $tmpDir = $this->bag->get('upload_tmp_dir');
        $imageDir = $this->bag->get('upload_image_dir');

        $uploadedImages = [];

        if(empty(array_filter($data))) {
            return $uploadedImages;
        }

        Assert::true($this->validateMainImage($data), 'field.main_image');

        $exceptions = [];

        foreach ($data as $image) {
            if (isset($image['id'])) {
                $imageObj = $this->imageRepository->find($image['id']);

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

            $mediaObj->setRelatedToType(Image::RELATED_TYPE_CATALOG);
            $mediaObj->setName($newName);
            $mediaObj->setIsmain($image['isMain']);
            $mediaObj->setOriginalName($newName.'.'.$file->guessExtension());
            $mediaObj->setFile($file);
            $mediaObj->setDevice(Image::DEVICE_DESKTOP);

            $this->imageRepository->persist($mediaObj);

            $uploadedImages[] = $mediaObj;
        }

        if (count($exceptions) > 0) {
            throw new BadRequestHttpException(json_encode(['images' => $exceptions]));
        }

        return $uploadedImages;
    }
}
