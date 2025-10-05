<?php

namespace App\Controller\Unique;

use App\Repository\ImageRepository;
use App\Services\ImageResizer;
use App\Services\ImageService;
use Liip\ImagineBundle\Exception\Binary\Loader\NotLoadableException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Routing\Annotation\Route;

class RenderImagesController extends AbstractController
{

    private ImageService $imageService;

    private ParameterBagInterface $parameterBag;

    private ImageResizer $imageResizer;

    private ImageRepository $imageRepository;

    /**
     * @param ImageService          $imageService
     * @param ParameterBagInterface $parameterBag
     * @param ImageResizer          $imageResizer
     * @param ImageRepository       $imageRepository
     */
    public function __construct(
        ImageService $imageService,
        ParameterBagInterface $parameterBag,
        ImageResizer $imageResizer,
        ImageRepository $imageRepository
    ) {
        $this->imageService = $imageService;
        $this->parameterBag = $parameterBag;
        $this->imageResizer = $imageResizer;
        $this->imageRepository = $imageRepository;
    }

    /**
     * @Route("/{entity}-image/{filter}/{name}.jpeg",
     *     methods={"GET"},
     *     name="app.image_show",
     *     requirements={
     *          "entity": "biography|blog|slider|location|banner|catalog|about-us|job|description",
     *          "name": ".*"
     *     })
     *
     * @param string $filter
     * @param string $name
     *
     * @return BinaryFileResponse
     */
    public function getImage(string $filter, string $name): BinaryFileResponse
    {
        $uploadDir = $this->parameterBag->get('upload_image_dir');

        try {
            $response = $this->imageResizer->renderImageWithFilter($uploadDir . $name, $filter);

            $response->setPublic();
            $response->setMaxAge(864000);

            return $response;
        } catch (NotLoadableException $notLoadableException) {
            $image = $this->imageRepository->findOneBy(['name' => $name]);

            $response = $this->imageResizer->renderImageWithFilter($uploadDir.$image->getOriginalName(), $filter);

            $response->setPublic();
            $response->setMaxAge(864000);


            return $response;

        }
    }
}
