<?php

namespace App\Controller\Admin\Api;

use App\Entity\Image;
use App\Services\ImageResizer;
use App\Services\ImageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class SummerNoteImageController extends AbstractController
{
    private RouterInterface $router;

    private ImageService $imageService;

    private ParameterBagInterface $bag;

    private string $uploadImageDir;

    public function __construct(
        RouterInterface $router,
        ImageService $imageService,
        ParameterBagInterface $bag
    ) {
        $this->router = $router;
        $this->imageService = $imageService;
        $this->bag = $bag;
        $this->uploadImageDir = $bag->get('upload_image_dir');
    }

    /**
     * @Route("/api/summernote-image/resize", name="admin.summernote_image_resize", methods={"POST"}, options={"expose": true})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function uploadImage(Request $request)
    {
        try {
            $entity = $request->request->get('entity');

            /** @var UploadedFile $file */
            $file = $request->files->get('tmp_image');
            $this->imageService->uploadToPath($file, $this->bag->get('upload_dir').$this->uploadImageDir);

            return $this->json([
                'file_url' => $this->router->generate('app.image_show', ['entity' => $entity, 'filter' => 'summernote_images', 'name' => $file->getClientOriginalName()]),
                'file_name' => $file->getClientOriginalName(),
            ]);

        } catch (\Throwable $throwable) {
            return $this->json(['message' => $throwable->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/api/remove-summernote-image/{filename}", methods={"DELETE"}, name="admin.remove_summernote_image", options={"expose": true})
     *
     * @param string $filename
     *
     * @return JsonResponse
     */
    public function removeImage(string $filename)
    {
        $file = $this->imageService->setFileObject([
            'file' => $this->bag->get('upload_dir').$this->uploadImageDir.$filename,
            'fileName' => $filename,
        ]);

        if ($file instanceof UploadedFile) {
            $this->imageService->deleteImage($file);
        }

        return $this->json([]);
    }
}
