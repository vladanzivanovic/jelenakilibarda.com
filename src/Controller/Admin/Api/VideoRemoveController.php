<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api;

use App\Entity\Slider;
use App\Entity\Video;
use App\Handler\SliderHandler;
use App\Handler\VideoEditHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class VideoRemoveController extends AbstractController
{
    private VideoEditHandler $videoEditHandler;

    public function __construct(
        VideoEditHandler $videoEditHandler
    ) {
        $this->videoEditHandler = $videoEditHandler;
    }

    /**
     * @Route("/api/remove-video/{id}", name="admin.remove_video_api", methods={"DELETE"}, options={"expose": true})
     *
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Video $video): JsonResponse
    {
        $this->videoEditHandler->remove($video);

        return $this->json(null);
    }
}
