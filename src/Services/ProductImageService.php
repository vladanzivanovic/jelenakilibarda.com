<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Image;
use App\Entity\Product;
use App\Entity\ProductHasImages;
use App\Entity\ProductTranslation;
use App\Repository\ImageRepository;
use App\Repository\ProductColorRepository;
use App\Repository\ProductHasImagesRepository;
use Gedmo\Sluggable\Util\Urlizer;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Webmozart\Assert\Assert;

final class ProductImageService
{
    use ImageServiceTrait;

    /**
     * @var ImageService
     */
    protected ImageService $img;

    private ImageRepository $imageRepository;

    private ParameterBagInterface $bag;

    private ProductColorRepository $colorRepository;

    private ProductHasImagesRepository $hasImagesRepository;

    private LoggerInterface $logger;

    /**
     * ProductImageService constructor.
     *
     * @param ImageService               $imageService
     * @param ParameterBagInterface      $bag
     * @param ImageRepository            $imageRepository
     * @param ProductColorRepository     $colorRepository
     * @param ProductHasImagesRepository $hasImagesRepository
     * @param LoggerInterface            $logger
     */
    public function __construct(
        ImageService $imageService,
        ParameterBagInterface $bag,
        ImageRepository $imageRepository,
        ProductColorRepository $colorRepository,
        ProductHasImagesRepository $hasImagesRepository,
        LoggerInterface $logger
    ) {
        $this->img = $imageService;
        $this->imageRepository = $imageRepository;
        $this->bag = $bag;
        $this->colorRepository = $colorRepository;
        $this->hasImagesRepository = $hasImagesRepository;
        $this->logger = $logger;
    }

    /**
     * @param ProductTranslation $productTranslation
     * @param array              $data
     *
     * @param bool               $fromImport
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function setImages(ProductTranslation $productTranslation, array $data, bool $fromImport = false): void
    {
        $rootDir = $this->bag->get('upload_dir');
        $tmpDir = true === $fromImport ? $this->bag->get('upload_import_dir') : $this->bag->get('upload_tmp_dir');
        $imageDir = $this->bag->get('upload_image_dir');

        $product = $productTranslation->getProduct();

        if(empty(array_filter($data))) {
            return;
        }

        Assert::true($this->validateMainImage($data), 'field.main_image');

        $slug = Urlizer::transliterate($productTranslation->getTitle());
        $exceptions = [];

        foreach ($data as $index => $image) {
            if (isset($image['id'])) {
                $imageObj = $this->imageRepository->find($image['id']);
                $hasImage = $this->hasImagesRepository->findOneBy(['product' => $product, 'image' => $imageObj]);

                if(isset($image['deleted']) && true === $image['deleted']) {
                    $image['file'] = $rootDir.$imageDir.$imageObj->getOriginalName();
                    $file = $this->img->setFileObject($image);
                    $imageObj->setFile($file);
                    $imageObj->setIsDeleted(true);

                    try {
                        $file = $this->img->setFileObject($image);
                        $imageObj->setFile($file);
                        $imageObj->setIsDeleted(true);
                    } catch (FileNotFoundException $notFoundException) {
                        $this->logger->warning(
                            sprintf('File "%s" for ad "%s" has not been found.',
                                $imageObj->getName(),
                                $imageObj->getId()
                            )
                        );
                    }

                    $this->hasImagesRepository->delete($hasImage);
                    $this->imageRepository->delete($imageObj);

                    continue;
                }

               $imageObj->setIsMain($image['isMain']);

                continue;
            }

            try {
                $image['file'] = $rootDir.$tmpDir.$image['fileName'];
                $file = $this->img->setFileObject($image);
            } catch (FileNotFoundException $exception) {
                $exceptions[] = $image['fileName'];

                continue;
            }

            $mediaObj = new Image();

            $image['file'] = $rootDir.$tmpDir.$image['fileName'];

            if (!($file instanceof UploadedFile)) {
                continue;
            }

            $newName = md5($file->getFilename().$slug);

            $mediaObj->setRelatedToType(Image::RELATED_TYPE_PRODUCT);
            $mediaObj->setName($newName);
            $mediaObj->setIsmain($image['isMain']);
            $mediaObj->setOriginalName($newName.'.'.$file->guessExtension());
            $mediaObj->setFile($file);
            $mediaObj->setDevice(Image::DEVICE_DESKTOP);

            $this->imageRepository->persist($mediaObj);

            $hasImages = new ProductHasImages();
            $hasImages->setProduct($product);
            $hasImages->setImage($mediaObj);

            $product->addProductHasImage($hasImages);
        }

        if (count($exceptions) > 0) {
            throw new BadRequestHttpException(json_encode(['images' => $exceptions]));
        }
    }
}